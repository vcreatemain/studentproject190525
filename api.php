<?php
header('Content-Type: application/json');

// Enable error logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php_errors.log');
error_reporting(E_ALL);

include 'db.php';

// Handle API requests
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'get_goals':
        $category = $_GET['category'] ?? '';
        try {
            $stmt = $conn->prepare("SELECT * FROM goals WHERE category = ?");
            $stmt->bind_param('s', $category);
            $stmt->execute();
            $result = $stmt->get_result();
            $goals = [];
            while ($row = $result->fetch_assoc()) {
                $row['target_value'] = json_decode($row['target_value'], true) ?? $row['target_value'];
                $row['progress'] = json_decode($row['progress'], true) ?? ['current_value' => 0];
                if ($row['goal_type'] === 'check' && ($row['category'] === 'mental' || $row['category'] === 'habits')) {
                    $subStmt = $conn->prepare("SELECT * FROM sub_tasks WHERE goal_id = ? ORDER BY id");
                    $subStmt->bind_param('s', $row['id']);
                    $subStmt->execute();
                    $subResult = $subStmt->get_result();
                    $subTasks = [];
                    while ($subRow = $subResult->fetch_assoc()) {
                        $subTasks[] = [
                            'name' => $subRow['name'],
                            'is_completed' => (bool)$subRow['is_completed'],
                            'streak' => $subRow['streak']
                        ];
                    }
                    $subStmt->close();
                    $row['sub_tasks'] = $subTasks;
                }
                $goals[] = $row;
            }
            $stmt->close();
            echo json_encode($goals);
        } catch (Exception $e) {
            error_log("get_goals error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch goals']);
        }
        break;

    case 'get_goal':
        $id = $_GET['id'] ?? '';
        try {
            $stmt = $conn->prepare("SELECT * FROM goals WHERE id = ?");
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $goal = $result->fetch_assoc();
            if ($goal) {
                $goal['target_value'] = json_decode($goal['target_value'], true) ?? $goal['target_value'];
                $goal['progress'] = json_decode($goal['progress'], true) ?? ['current_value' => 0];
            }
            $stmt->close();
            echo json_encode($goal ?: ['error' => 'Goal not found']);
        } catch (Exception $e) {
            error_log("get_goal error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch goal']);
        }
        break;

    case 'update_progress':
        $goalId = $_POST['goal_id'] ?? '';
        $type = $_POST['type'] ?? 'count';
        try {
            $stmt = $conn->prepare("SELECT goal_type, progress, streak FROM goals WHERE id = ?");
            $stmt->bind_param('s', $goalId);
            $stmt->execute();
            $result = $stmt->get_result();
            $goal = $result->fetch_assoc();
            $stmt->close();

            if (!$goal) {
                echo json_encode(['error' => 'Goal not found']);
                break;
            }

            $progress = json_decode($goal['progress'], true) ?? ['current_value' => 0];
            $streak = $goal['streak'] ?? 0;

            if ($type === 'macro') {
                $protein = (int)($_POST['protein'] ?? 0);
                $carbs = (int)($_POST['carbs'] ?? 0);
                $fats = (int)($_POST['fats'] ?? 0);
                $progress['protein'] = ($progress['protein'] ?? 0) + $protein;
                $progress['carbs'] = ($progress['carbs'] ?? 0) + $carbs;
                $progress['fats'] = ($progress['fats'] ?? 0) + $fats;
            } else if ($type === 'check') {
                $progress['is_completed'] = (bool)($_POST['value'] ?? 0);
                $streak = $progress['is_completed'] ? $streak + 1 : max(0, $streak - 1);
            } else {
                $value = (int)($_POST['value'] ?? 0);
                $progress['current_value'] = ($progress['current_value'] ?? 0) + $value;
                if ($type === 'streak' || $goal['goal_type'] === 'streak') {
                    $streak++;
                }
            }

            $progressJson = json_encode($progress);
            $stmt = $conn->prepare("UPDATE goals SET progress = ?, streak = ? WHERE id = ?");
            $stmt->bind_param('sis', $progressJson, $streak, $goalId);
            $stmt->execute();
            $stmt->close();

            $historyStmt = $conn->prepare("INSERT INTO history (goal_id, current_value, date) VALUES (?, ?, NOW())");
            $historyValue = json_encode($type === 'check' ? ['is_completed' => $progress['is_completed']] : $progress);
            $historyStmt->bind_param('ss', $goalId, $historyValue);
            $historyStmt->execute();
            $historyStmt->close();

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            error_log("update_progress error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update progress']);
        }
        break;

    case 'update_sub_task':
        $goalId = $_POST['goal_id'] ?? '';
        $subTaskIndex = (int)($_POST['sub_task_index'] ?? -1);
        $isCompleted = filter_var($_POST['is_completed'], FILTER_VALIDATE_BOOLEAN);
        try {
            $subStmt = $conn->prepare("SELECT id, streak FROM sub_tasks WHERE goal_id = ? ORDER BY id LIMIT ?, 1");
            $subStmt->bind_param('si', $goalId, $subTaskIndex);
            $subStmt->execute();
            $subResult = $subStmt->get_result();
            $subTask = $subResult->fetch_assoc();
            $subStmt->close();

            if (!$subTask) {
                error_log("update_sub_task: Sub-task not found for goal_id=$goalId, index=$subTaskIndex");
                echo json_encode(['error' => 'Sub-task not found']);
                break;
            }

            $subTaskId = $subTask['id'];
            $streak = $isCompleted ? $subTask['streak'] + 1 : max(0, $subTask['streak'] - 1);
            $updateStmt = $conn->prepare("UPDATE sub_tasks SET is_completed = ?, streak = ? WHERE id = ?");
            $updateStmt->bind_param('iii', $isCompleted, $streak, $subTaskId);
            $updateStmt->execute();
            $updateStmt->close();

            $countStmt = $conn->prepare("SELECT COUNT(*) as total, SUM(is_completed) as completed FROM sub_tasks WHERE goal_id = ?");
            $countStmt->bind_param('s', $goalId);
            $countStmt->execute();
            $result = $countStmt->get_result();
            $counts = $result->fetch_assoc();
            $countStmt->close();

            if ($counts['total'] === $counts['completed']) {
                $streakStmt = $conn->prepare("UPDATE goals SET streak = streak + 1, progress = ? WHERE id = ?");
                $progress = json_encode(['is_completed' => true]);
                $streakStmt->bind_param('ss', $progress, $goalId);
                $streakStmt->execute();
                $streakStmt->close();
            } else {
                $streakStmt = $conn->prepare("UPDATE goals SET progress = ? WHERE id = ?");
                $progress = json_encode(['is_completed' => false]);
                $streakStmt->bind_param('ss', $progress, $goalId);
                $streakStmt->execute();
                $streakStmt->close();
            }

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            error_log("update_sub_task error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update sub-task']);
        }
        break;

    case 'create_goal':
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $category = $_POST['category'] ?? '';
        $goalType = $_POST['goal_type'] ?? '';
        $targetValue = $_POST['target_value'] ?? '0';
        $unit = $_POST['unit'] ?? '';
        try {
            if (!$title || !$description || !$category || !$goalType) {
                error_log("create_goal: Missing required fields");
                echo json_encode(['error' => 'Missing required fields']);
                break;
            }

            $id = 'goal_' . uniqid();
            $targetValue = $goalType === 'macro' ? $targetValue : (int)$targetValue;
            $progress = $goalType === 'macro' ? json_encode(['protein' => 0, 'carbs' => 0, 'fats' => 0]) : ($goalType === 'check' ? json_encode(['is_completed' => false]) : json_encode(['current_value' => 0]));
            $stmt = $conn->prepare("INSERT INTO goals (id, title, description, category, goal_type, target_value, unit, progress, streak) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
            $stmt->bind_param('ssssssss', $id, $title, $description, $category, $goalType, $targetValue, $unit, $progress);
            $stmt->execute();
            $stmt->close();

            echo json_encode(['success' => true, 'id' => $id]);
        } catch (Exception $e) {
            error_log("create_goal error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create goal']);
        }
        break;

    case 'add_sub_task':
        $goalId = $_POST['goal_id'] ?? '';
        $name = $_POST['name'] ?? '';
        try {
            $stmt = $conn->prepare("INSERT INTO sub_tasks (goal_id, name, is_completed, streak) VALUES (?, ?, 0, 0)");
            $stmt->bind_param('ss', $goalId, $name);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            error_log("add_sub_task error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add sub-task']);
        }
        break;

    case 'update_targets':
        $goalId = $_POST['goal_id'] ?? '';
        $targets = $_POST['targets'] ?? '{}';
        try {
            $stmt = $conn->prepare("UPDATE goals SET target_value = ? WHERE id = ?");
            $stmt->bind_param('ss', $targets, $goalId);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            error_log("update_targets error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update targets']);
        }
        break;

    case 'get_history':
        $goalId = $_GET['goal_id'] ?? '';
        try {
            $stmt = $conn->prepare("SELECT * FROM history WHERE goal_id = ? ORDER BY date DESC");
            $stmt->bind_param('s', $goalId);
            $stmt->execute();
            $result = $stmt->get_result();
            $history = [];
            while ($row = $result->fetch_assoc()) {
                $row['current_value'] = json_decode($row['current_value'], true) ?? $row['current_value'];
                $history[] = $row;
            }
            $stmt->close();
            $goalStmt = $conn->prepare("SELECT * FROM goals WHERE id = ?");
            $goalStmt->bind_param('s', $goalId);
            $goalStmt->execute();
            $goalResult = $goalStmt->get_result();
            $goal = $goalResult->fetch_assoc();
            $goal['target_value'] = json_decode($goal['target_value'], true) ?? $goal['target_value'];
            $goalStmt->close();
            echo json_encode(['history' => $history, 'goal' => $goal]);
        } catch (Exception $e) {
            error_log("get_history error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch history']);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
}

$conn->close();
?>