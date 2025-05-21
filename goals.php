<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellness Goal Tracker</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --teal: #20b2aa;
            --aqua: #00FFFF;
            --ocean-blue: #4682B4;
            --deep-ocean: #1e3a5f;
            --olympic-blue: #0085C7;
            --light-teal: #7fffd4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--deep-ocean), var(--ocean-blue));
            color: white;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            padding: 20px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-out;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--aqua), var(--light-teal));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .date-display {
            font-size: 1.2rem;
            color: #ffffff;
            font-weight: 300;
        }

        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.1);
        }

        .tab {
            flex: 1;
            padding: 15px 0;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            position: relative;
            overflow: hidden;
        }

        .tab:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .tab.active {
            background-color: var(--teal);
            color: white;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--aqua);
            animation: slideIn 0.3s ease-out;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .tab-content.active {
            display: block;
        }

        .goal-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 5px solid var(--teal);
            position: relative;
            overflow: hidden;
        }

        .goal-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .goal-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .goal-title h3 {
            font-size: 1.2rem;
        }

        .goal-progress {
            margin-top: 15px;
        }

        .progress-bar {
            height: 8px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 8px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, var(--aqua), var(--olympic-blue));
            border-radius: 4px;
            transition: width 0.5s ease-in-out;
        }

        .goal-actions {
            display: flex;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            margin-right: 10px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .btn i {
            margin-right: 5px;
        }

        .btn-primary {
            background-color: var(--teal);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--light-teal);
            transform: scale(1.05);
        }

        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .custom-checkbox {
            width: 24px;
            height: 24px;
            border: 2px solid var(--teal);
            border-radius: 6px;
            margin-right: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            flex-shrink: 0;
        }

        .custom-checkbox.checked {
            background-color: var(--teal);
            transform: scale(1.1);
        }

        .custom-checkbox.checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: white;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.2);
        }

        input[type="range"] {
            -webkit-appearance: none;
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            outline: none;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background: var(--teal);
            border-radius: 50%;
            cursor: pointer;
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .streak-counter {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.15);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-left: 10px;
        }

        .streak-counter i {
            color: #FFD700;
            margin-right: 5px;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 20px;
            max-width: 500px;
            width: 90%;
            position: relative;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease-out;
        }

        .modal .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
        }

        .trend-chart {
            margin-top: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 1;
            }

            100% {
                transform: scale(10);
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            .tabs {
                flex-direction: column;
            }

            .tab {
                padding: 12px 0;
            }

            .goal-title {
                flex-direction: column;
                align-items: flex-start;
            }

            .streak-counter {
                margin-left: 0;
                margin-top: 8px;
            }
        }

        .btn-home {
            background-color: var(--teal);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            margin-top: 15px;
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-home:hover {
            background-color: var(--light-teal);
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-home i {
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .btn-home {
                padding: 8px 16px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Wellness Goal Tracker</h1>
            <div class="date-display" id="currentDate">Loading date...</div>
            <a href="index.php" class="btn btn-home" id="goHomeBtn"><i class="fas fa-home"></i> Go Home</a>
        </header>
        <div class="tabs">
            <div class="tab active" data-tab="mental">Mental Wellness</div>
            <div class="tab" data-tab="nutrition">Nutrition</div>
            <div class="tab" data-tab="custom">Custom Goals</div>
            <div class="tab" data-tab="habits">Habit Building</div>
        </div>
        <div class="tab-content active" id="mental"></div>
        <div class="tab-content" id="nutrition"></div>
        <div class="tab-content" id="custom"></div>
        <div class="tab-content" id="habits">

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize app
            updateDate();
            loadTabContent('mental');

            // Tab switching
            document.querySelectorAll('.tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                    tab.classList.add('active');
                    const tabName = tab.getAttribute('data-tab');
                    document.getElementById(tabName).classList.add('active');
                    loadTabContent(tabName);
                });
            });

            // Checkbox functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('custom-checkbox') || e.target.parentElement.classList.contains('custom-checkbox')) {
                    const checkbox = e.target.classList.contains('custom-checkbox') ? e.target : e.target.parentElement;
                    const isChecked = checkbox.classList.contains('checked');
                    const goalCard = checkbox.closest('.goal-card');
                    const goalId = goalCard.dataset.goalId;
                    const subTaskIndex = checkbox.dataset.subTaskIndex;
                    if (!isChecked) {
                        if (subTaskIndex !== undefined) {
                            updateSubTask(goalId, parseInt(subTaskIndex), true).then(() => {
                                checkbox.classList.add('checked');
                                createRippleEffect(checkbox, e);
                                loadTabContent(goalCard.closest('.tab-content').id);
                            });
                        } else {
                            updateGoalProgress(goalId, 1, 'check').then(() => {
                                checkbox.classList.add('checked');
                                createRippleEffect(checkbox, e);
                                loadTabContent(goalCard.closest('.tab-content').id);
                            });
                        }
                    }
                }
            });

            // Button clicks
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn') || e.target.parentElement.classList.contains('btn')) {
                    const button = e.target.classList.contains('btn') ? e.target : e.target.parentElement;
                    button.style.transform = 'scale(0.95)';
                    setTimeout(() => button.style.transform = '', 200);
                    const goalCard = button.closest('.goal-card');
                    const goalId = goalCard ? goalCard.dataset.goalId : null;
                    if (button.innerHTML.includes('Start Session')) {
                        startMeditationSession(goalId, goalCard);
                    } else if (button.innerHTML.includes('Add Serving')) {
                        addServing(goalId, goalCard);
                    } else if (button.innerHTML.includes('Mark Today Complete')) {
                        markDayComplete(goalId, goalCard);
                    } else if (button.innerHTML.includes('Log Meal')) {
                        showMacroLogForm(goalId, goalCard);
                    } else if (button.innerHTML.includes('Adjust Targets')) {
                        showMacroAdjustForm(goalId, goalCard);
                    } else if (button.innerHTML.includes('Create Goal')) {
                        createCustomGoal(goalCard);
                    } else if (button.innerHTML.includes('Add New Habit')) {
                        showAddHabitForm(goalId, goalCard);
                    } else if (button.innerHTML.includes('Add Activity')) {
                        showAddActivityForm(goalId, goalCard);
                    } else if (button.innerHTML.includes('History') || button.innerHTML.includes('View Trends') || button.innerHTML.includes('Detailed Stats')) {
                        showHistory(goalId);
                    }
                }
            });

            function updateDate() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
            }

            function loadTabContent(tabName) {
                fetch(`api.php?action=get_goals&category=${tabName}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) throw new Error(data.error);
                        const tabContent = document.getElementById(tabName);
                        tabContent.innerHTML = '';
                        if (data.length === 0) {
                            tabContent.innerHTML = `<div class="no-goals">No goals found for this category. Create one to get started!</div>`;
                        } else {
                            data.forEach(goal => {
                                const goalCard = createGoalCard(goal, tabName);
                                tabContent.appendChild(goalCard);
                            });
                        }
                        if (tabName === 'custom') {
                            tabContent.appendChild(createNewGoalForm());
                        }
                        animateProgressBars();
                    })
                    .catch(error => {
                        console.error('Error fetching goals:', error);
                        alert('Failed to load goals. Please try again.');
                    });
            }

            function createGoalCard(goal, category) {
                const card = document.createElement('div');
                card.className = 'goal-card';
                card.dataset.goalId = goal.id;
                let cardContent = `
                    <div class="goal-title">
                        <h3>${goal.title}</h3>
                        ${goal.streak ? `<div class="streak-counter"><i class="fas fa-fire"></i> <span>${goal.streak} days</span></div>` : ''}
                    </div>
                    <p>${goal.description}</p>
                `;
                if (goal.goal_type === 'count') {
                    const progress = goal.progress?.current_value || 0;
                    const percent = Math.min(Math.round((progress / goal.target_value) * 100), 100);
                    cardContent += `
                        <div class="goal-progress">
                            <div class="progress-label">Progress: <span>${progress}/${goal.target_value} ${goal.unit || ''}</span></div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${percent}%"></div>
                            </div>
                        </div>
                    `;
                } else if (goal.goal_type === 'macro') {
                    const protein = goal.progress?.protein || 0;
                    const carbs = goal.progress?.carbs || 0;
                    const fats = goal.progress?.fats || 0;
                    const proteinTarget = goal.target_value.protein;
                    const carbsTarget = goal.target_value.carbs;
                    const fatsTarget = goal.target_value.fats;
                    cardContent += `
                        <div class="goal-progress">
                            <div class="progress-label">Protein: <span>${protein}g/${proteinTarget}g</span></div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${Math.min((protein / proteinTarget) * 100, 100)}%"></div>
                            </div>
                        </div>
                        <div class="goal-progress">
                            <div class="progress-label">Carbs: <span>${carbs}g/${carbsTarget}g</span></div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${Math.min((carbs / carbsTarget) * 100, 100)}%"></div>
                            </div>
                        </div>
                        <div class="goal-progress">
                            <div class="progress-label">Fats: <span>${fats}g/${fatsTarget}g</span></div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${Math.min((fats / fatsTarget) * 100, 100)}%"></div>
                            </div>
                        </div>
                    `;
                } else if (goal.goal_type === 'check') {
                    if (category === 'habits' && goal.habits) {
                        goal.habits.forEach((habit, index) => {
                            cardContent += `
                                <div class="checkbox-wrapper">
                                    <div class="custom-checkbox ${habit.is_completed ? 'checked' : ''}" data-sub-task-index="${index}"></div>
                                    <div class="checkbox-label">${habit.name} <span class="streak-counter"><i class="fas fa-fire"></i> ${habit.streak} days</span></div>
                                </div>
                            `;
                        });

                    <?php
header('Content-Type: application/json');

// Enable error logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php_errors.log');
error_reporting(E_ALL);

include 'db.php';

// Initialize cardContent for JavaScript
$cardContent = '';

try {
    // Query sub_tasks for goal_id starting with 'habits'
    $stmt = $conn->prepare("SELECT is_completed, streak FROM sub_tasks WHERE goal_id LIKE 'habits%'");
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize arrays for weekly data
    $weeklyCompletion = [0 => 0, 1 => 0, 2 => 0, 3 => 0]; // Completed sub-tasks per week
    $weeklyCounts = [0 => 0, 1 => 0, 2 => 0, 3 => 0]; // Total sub-tasks per week
    $taskCount = 0;
    $totalStreaks = 0;

    // Process sub-tasks
    while ($row = $result->fetch_assoc()) {
        $taskCount++;
        $streak = (int)$row['streak'];
        $totalStreaks += $streak;
        if ($row['is_completed']) {
            $weeklyCompletion[0]++; // Assume current week for completed tasks
        }
        $weeklyCounts[0]++;
    }
    $stmt->close();

    // Calculate completion percentages
    $percentages = [];
    // Current week (Week 4)
    $percentages[0] = $weeklyCounts[0] > 0 ? round(($weeklyCompletion[0] / $weeklyCounts[0]) * 100) : 0;
    // Estimate prior weeks using streak (assuming streaks decay over time)
    $avgStreak = $taskCount > 0 ? $totalStreaks / $taskCount : 0;
    for ($i = 1; $i < 4; $i++) {
        // Rough approximation: reduce completion rate for older weeks based on streak
        $percentages[$i] = $taskCount > 0 ? round(min($percentages[0], ($avgStreak / ($i + 1)) * 10)) : 0;
    }

    // Generate chart HTML
    $cardContent .= '<div class="goal-card">
        <div class="goal-title">
            <h3>Habit Progress Chart</h3>
        </div>
        <p>Your consistency over the past 4 weeks</p>
        <div style="display: flex; justify-content: space-between; margin-top: 15px; margin-bottom: 5px;">';

    // Generate bars for each week (Week 4 is most recent)
    for ($i = 0; $i < 4; $i++) {
        $weekLabel = "Week " . (4 - $i);
        $height = $percentages[$i] . '%';
        $cardContent .= '
            <div style="text-align: center; flex: 1;">
                <div style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">' . htmlspecialchars($weekLabel) . '</div>
                <div style="height: 100px; display: flex; align-items: flex-end; justify-content: center;">
                    <div style="width: 30px; background: linear-gradient(to top, var(--teal), var(--aqua)); height: ' . htmlspecialchars($height) . '; border-radius: 3px 3px 0 0;"></div>
                </div>
            </div>';
    }

    $cardContent .= '
        </div>
        <div class="goal-actions">
            <button class="btn btn-secondary"><i class="fas fa-chart-line"></i> Detailed Stats</button>
        </div>
    </div>';

} catch (Exception $e) {
    error_log("habit_chart error: " . $e->getMessage());
    $cardContent .= '<div class="goal-card"><p>Error loading chart</p></div>';
}

// Output JavaScript to assign cardContent
?>
cardContent += `<?php echo addslashes($cardContent); ?>`;

                    } else if (category === 'mental' && goal.sub_tasks) {
                        goal.sub_tasks.forEach((task, index) => {
                            cardContent += `
                                <div class="checkbox-wrapper">
                                    <div class="custom-checkbox ${task.is_completed ? 'checked' : ''}" data-sub-task-index="${index}"></div>
                                    <div class="checkbox-label">${task.name}</div>
                                </div>
                            `;
                        });
                    } else {
                        cardContent += `
                            <div class="checkbox-wrapper">
                                <div class="custom-checkbox ${goal.progress?.is_completed ? 'checked' : ''}"></div>
                                <div class="checkbox-label">Completed today</div>
                            </div>
                        `;
                    }
                } else if (goal.goal_type === 'streak') {
                    const progress = goal.progress?.current_value || 0;
                    const percent = Math.min(Math.round((progress / goal.target_value) * 100), 100);
                    cardContent += `
                        <div class="goal-progress">
                            <div class="progress-label">Progress: <span>${progress}/${goal.target_value} days</span></div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${percent}%"></div>
                            </div>
                        </div>
                    `;
                } else if (goal.goal_type === 'chart') {
                    cardContent += `
                        <div class="trend-chart" style="display: flex; justify-content: space-between; margin-top: 15px; margin-bottom: 5px;">
                            ${goal.chart_data.map(data => `
                                <div style="text-align: center; flex: 1;">
                                    <div style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">${data.week}</div>
                                    <div style="height: 100px; display: flex; align-items: flex-end; justify-content: center;">
                                        <div style="width: 30px; background: linear-gradient(to top, var(--teal), var(--aqua)); height: ${data.height}%; border-radius: 3px 3px 0 0;"></div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    `;
                }
                cardContent += `<div class="goal-actions">`;
                if (category === 'mental') {
                    if (goal.title.includes('Meditation')) {
                        cardContent += `
                            <button class="btn btn-primary"><i class="fas fa-play"></i> Start Session</button>
                            <button class="btn btn-secondary"><i class="fas fa-history"></i> History</button>
                        `;
                    } else {
                        cardContent += `
                            <button class="btn btn-secondary"><i class="fas fa-plus"></i> Add Activity</button>
                        `;
                    }
                } else if (category === 'nutrition') {
                    if (goal.title.includes('Fruits')) {
                        cardContent += `
                            <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Serving</button>
                            <button class="btn btn-secondary"><i class="fas fa-chart-line"></i> View Trends</button>
                        `;
                    } else {
                        cardContent += `
                            <button class="btn btn-primary"><i class="fas fa-utensils"></i> Log Meal</button>
                            <button class="btn btn-secondary"><i class="fas fa-cog"></i> Adjust Targets</button>
                        `;
                    }
                } else if (category === 'custom') {
                    if (goal.title.includes('No Soda')) {
                        cardContent += `
                            <button class="btn btn-primary"><i class="fas fa-check"></i> Mark Today Complete</button>
                        `;
                    } else if (goal.title.includes('Morning Stretching')) {
                        cardContent += `
                            <button class="btn btn-secondary"><i class="fas fa-play"></i> Guided Routine</button>
                        `;
                    }
                } else if (category === 'habits') {
                    cardContent += `
                        <button class="btn btn-primary"><i class="fas fa-plus"></i> Add New Habit</button>
                        <button class="btn btn-secondary"><i class="fas fa-chart-line"></i> Detailed Stats</button>
                    `;
                }
                cardContent += `</div>`;
                card.innerHTML = cardContent;
                return card;
            }

            function createNewGoalForm() {
                const form = document.createElement('div');
                form.className = 'goal-card';
                form.innerHTML = `
                    <div class="goal-title"><h3>Create New Goal</h3></div>
                    <div class="form-group">
                        <label for="newGoalTitle">Goal Title</label>
                        <input type="text" id="newGoalTitle" placeholder="Enter goal title">
                    </div>
                    <div class="form-group">
                        <label for="newGoalDesc">Description</label>
                        <textarea id="newGoalDesc" rows="2" placeholder="Describe your goal"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="goalCategory">Category</label>
                        <select id="goalCategory">
                            <option value="mental">Mental Wellness</option>
                            <option value="nutrition">Nutrition</option>
                            <option value="custom">Custom Goals</option>
                            <option value="habits">Habit Building</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="goalType">Goal Type</label>
                        <select id="goalType">
                            <option value="count">Counter (track numbers)</option>
                            <option value="check">Checkbox (yes/no completion)</option>
                            <option value="streak">Streak (continuous days)</option>
                            <option value="macro">Macro Tracking (nutrition)</option>
                        </select>
                    </div>
                    <div class="form-group" id="targetValueGroup">
                        <label for="targetValue">Target Value</label>
                        <input type="number" id="targetValue" placeholder="Enter target value">
                    </div>
                    <div class="form-group" id="unitGroup">
                        <label for="unit">Unit</label>
                        <input type="text" id="unit" placeholder="Enter unit (e.g., minutes, servings)">
                    </div>
                    <div class="goal-actions">
                        <button class="btn btn-primary"><i class="fas fa-plus"></i> Create Goal</button>
                    </div>
                `;
                form.querySelector('#goalType').addEventListener('change', function() {
                    const type = this.value;
                    form.querySelector('#targetValueGroup').style.display = type === 'check' ? 'none' : 'block';
                    form.querySelector('#unitGroup').style.display = type === 'check' || type === 'streak' ? 'none' : 'block';
                });
                return form;
            }

            function animateProgressBars() {
                const visibleTab = document.querySelector('.tab-content.active');
                if (!visibleTab) return;
                const progressBars = visibleTab.querySelectorAll('.progress-fill');
                progressBars.forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => bar.style.width = width, 100);
                });
            }

            function createRippleEffect(element, event) {
                const ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.width = '5px';
                ripple.style.height = '5px';
                ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
                ripple.style.borderRadius = '50%';
                ripple.style.transform = 'translate(-50%, -50%)';
                ripple.style.animation = 'ripple 0.6s linear';
                const rect = element.getBoundingClientRect();
                ripple.style.left = (event.clientX - rect.left) + 'px';
                ripple.style.top = (event.clientY - rect.top) + 'px';
                element.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            }

            function updateGoalProgress(goalId, value, type = 'count') {
                const body = type === 'macro' ?
                    `goal_id=${goalId}&protein=${value.protein}&carbs=${value.carbs}&fats=${value.fats}` :
                    `goal_id=${goalId}&value=${value}&type=${type}`;
                return fetch('api.php?action=update_progress', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: body
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) throw new Error(data.error);
                        return data;
                    });
            }

            function updateSubTask(goalId, subTaskIndex, isCompleted) {
                return fetch('api.php?action=update_sub_task', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `goal_id=${goalId}&sub_task_index=${subTaskIndex}&is_completed=${isCompleted}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) throw new Error(data.error);
                        return data;
                    });
            }

            function addServing(goalId, goalCard) {
                updateGoalProgress(goalId, 1).then(() => {
                    const progressText = goalCard.querySelector('.progress-label span');
                    const progressBar = goalCard.querySelector('.progress-fill');
                    const current = parseInt(progressText.textContent.split('/')[0]);
                    const target = parseInt(progressText.textContent.split('/')[1]);
                    const unit = progressText.textContent.includes('servings') ? 'servings' : '';
                    if (current < target) {
                        const newValue = current + 1;
                        progressText.textContent = `${newValue}/${target} ${unit}`;
                        const percent = Math.min(Math.round((newValue / target) * 100), 100);
                        progressBar.style.width = `${percent}%`;
                    }
                });
            }

            function markDayComplete(goalId, goalCard) {
                updateGoalProgress(goalId, 1, 'streak').then(() => {
                    const progressText = goalCard.querySelector('.progress-label span');
                    const progressBar = goalCard.querySelector('.progress-fill');
                    const streakCounter = goalCard.querySelector('.streak-counter span');
                    const current = parseInt(progressText.textContent.split('/')[0]);
                    const target = parseInt(progressText.textContent.split('/')[1].split(' ')[0]);
                    if (current < target) {
                        const newValue = current + 1;
                        progressText.textContent = `${newValue}/${target} days`;
                        const percent = Math.min(Math.round((newValue / target) * 100), 100);
                        progressBar.style.width = `${percent}%`;
                        if (streakCounter) {
                            streakCounter.textContent = `${newValue} days`;
                        }
                    }
                    loadTabContent('custom');
                });
            }

            function showMacroLogForm(goalId, goalCard) {
                const modal = document.createElement('div');
                modal.className = 'modal';
                modal.innerHTML = `
                    <div class="modal-content">
                        <span class="close">×</span>
                        <h3>Log Meal Macros</h3>
                        <div class="form-group">
                            <label>Protein (g)</label>
                            <input type="number" id="logProtein" placeholder="Protein grams">
                        </div>
                        <div class="form-group">
                            <label>Carbs (g)</label>
                            <input type="number" id="logCarbs" placeholder="Carb grams">
                        </div>
                        <div class="form-group">
                            <label>Fats (g)</label>
                            <input type="number" id="logFats" placeholder="Fat grams">
                        </div>
                        <div class="goal-actions">
                            <button class="btn btn-primary" id="submitMacros"><i class="fas fa-check"></i> Submit</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                modal.querySelector('.close').addEventListener('click', () => modal.remove());
                modal.querySelector('#submitMacros').addEventListener('click', () => {
                    alert('Meal Logged successfully!');
                    const protein = parseInt(document.getElementById('logProtein').value) || 0;
                    const carbs = parseInt(document.getElementById('logCarbs').value) || 0;
                    const fats = parseInt(document.getElementById('logFats').value) || 0;
                    updateGoalProgress(goalId, {
                        protein,
                        carbs,
                        fats
                    }, 'macro').then(() => {
                        modal.remove();
                        loadTabContent('nutrition');
                    });
                });
            }

            function showMacroAdjustForm(goalId, goalCard) {
                fetch(`api.php?action=get_goal&id=${goalId}`)
                    .then(response => response.json())
                    .then(goal => {
                        const modal = document.createElement('div');
                        modal.className = 'modal';
                        modal.innerHTML = `
                            <div class="modal-content">
                                <span class="close">×</span>
                                <h3>Adjust Macro Targets</h3>
                                <div class="form-group">
                                    <label>Protein (g): <span id="proteinValue">${goal.target_value.protein}</span></label>
                                    <input type="range" id="proteinSlider" min="50" max="300" value="${goal.target_value.protein}">
                                </div>
                                <div class="form-group">
                                    <label>Carbs (g): <span id="carbsValue">${goal.target_value.carbs}</span></label>
                                    <input type="range" id="carbsSlider" min="100" max="500" value="${goal.target_value.carbs}">
                                </div>
                                <div class="form-group">
                                    <label>Fats (g): <span id="fatsValue">${goal.target_value.fats}</span></label>
                                    <input type="range" id="fatsSlider" min="30" max="150" value="${goal.target_value.fats}">
                                </div>
                                <div class="goal-actions">
                                    <button class="btn btn-primary" id="submitTargets"><i class="fas fa-check"></i> Save</button>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(modal);
                        const updateValue = (sliderId, valueId) => {
                            const slider = modal.querySelector(`#${sliderId}`);
                            const value = modal.querySelector(`#${valueId}`);
                            slider.addEventListener('input', () => value.textContent = slider.value);
                        };
                        updateValue('proteinSlider', 'proteinValue');
                        updateValue('carbsSlider', 'carbsValue');
                        updateValue('fatsSlider', 'fatsValue');
                        modal.querySelector('.close').addEventListener('click', () => modal.remove());
                        modal.querySelector('#submitTargets').addEventListener('click', () => {
                            const newTargets = {
                                protein: parseInt(modal.querySelector('#proteinSlider').value),
                                carbs: parseInt(modal.querySelector('#carbsSlider').value),
                                fats: parseInt(modal.querySelector('#fatsSlider').value)
                            };
                            fetch('api.php?action=update_targets', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `goal_id=${goalId}&targets=${encodeURIComponent(JSON.stringify(newTargets))}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.error) throw new Error(data.error);
                                    modal.remove();
                                    loadTabContent('nutrition');
                                });
                        });
                    });
            }

            function createCustomGoal(goalCard) {
                const title = document.getElementById('newGoalTitle').value;
                const description = document.getElementById('newGoalDesc').value;
                const category = document.getElementById('goalCategory').value;
                const goalType = document.getElementById('goalType').value;
                const targetValue = parseInt(document.getElementById('targetValue')?.value) || 0;
                const unit = document.getElementById('unit')?.value || '';
                if (!title || !description) {
                    alert('Please fill in all required fields');
                    return;
                }
                const target = goalType === 'macro' ? JSON.stringify({
                    protein: 120,
                    carbs: 200,
                    fats: 60
                }) : targetValue;
                fetch('api.php?action=create_goal', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&category=${category}&goal_type=${goalType}&target_value=${encodeURIComponent(target)}&unit=${encodeURIComponent(unit)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            loadTabContent(category);
                        }
                    });
            }

            function showAddHabitForm(goalId, goalCard) {
                const modal = document.createElement('div');
                modal.className = 'modal';
                modal.innerHTML = `
                    <div class="modal-content">
                        <span class="close">×</span>
                        <h3>Add New Habit</h3>
                        <div class="form-group">
                            <label>Habit Name</label>
                            <input type="text" id="habitName" placeholder="Enter habit name">
                        </div>
                        <div class="form-group">
                            <label>Target Days</label>
                            <input type="number" id="habitTarget" placeholder="Enter target days (e.g., 30)">
                        </div>
                        <div class="goal-actions">
                            <button class="btn btn-primary" id="submitHabit"><i class="fas fa-plus"></i> Create Habit</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                modal.querySelector('.close').addEventListener('click', () => modal.remove());
                modal.querySelector('#submitHabit').addEventListener('click', () => {
                    const name = document.getElementById('habitName').value;
                    const target = parseInt(document.getElementById('habitTarget').value) || 30;
                    if (!name) {
                        alert('Please enter a habit name');
                        return;
                    }
                    fetch('api.php?action=add_habit', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `goal_id=${goalId}&name=${encodeURIComponent(name)}&target=${target}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                modal.remove();
                                loadTabContent('habits');
                            }
                        });
                });
            }

            function showAddActivityForm(goalId, goalCard) {
                const modal = document.createElement('div');
                modal.className = 'modal';
                modal.innerHTML = `
                    <div class="modal-content">
                        <span class="close">×</span>
                        <h3>Add New Activity</h3>
                        <div class="form-group">
                            <label>Activity Name</label>
                            <input type="text" id="activityName" placeholder="Enter activity name">
                        </div>
                        <div class="goal-actions">
                            <button class="btn btn-primary" id="submitActivity"><i class="fas fa-plus"></i> Add Activity</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                modal.querySelector('.close').addEventListener('click', () => modal.remove());
                modal.querySelector('#submitActivity').addEventListener('click', () => {
                    const name = document.getElementById('activityName').value;
                    if (!name) {
                        alert('Please enter an activity name');
                        return;
                    }
                    fetch('api.php?action=add_sub_task', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `goal_id=${goalId}&name=${encodeURIComponent(name)}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                modal.remove();
                                loadTabContent('mental');
                            }
                        });
                });
            }

            function showHistory(goalId) {
                fetch(`api.php?action=get_history&goal_id=${goalId}`)
                    .then(response => response.json())
                    .then(data => {
                        const modal = document.createElement('div');
                        modal.className = 'modal';
                        let historyContent = '<div class="modal-content"><span class="close">×</span><h3>Progress History</h3>';
                        if (data.error) {
                            historyContent += `<div class="error">${data.error}</div>`;
                        } else if (data.history.length === 0) {
                            historyContent += `<div class="no-history">No history found for this goal</div>`;
                        } else {
                            const goal = data.goal;
                            if (goal.goal_type === 'count' && goal.title.includes('Fruits')) {
                                historyContent += '<div class="trend-chart" style="display: flex; justify-content: space-between; margin-top: 15px; margin-bottom: 5px;">';
                                const days = Array(7).fill(0).map((_, i) => {
                                    const date = new Date();
                                    date.setDate(date.getDate() - i);
                                    const entry = data.history.find(h => new Date(h.date).toDateString() === date.toDateString());
                                    return {
                                        day: date.toLocaleDateString('en-US', {
                                            weekday: 'short'
                                        }),
                                        value: entry ? entry.current_value : 0
                                    };
                                }).reverse();
                                days.forEach(day => {
                                    const height = Math.min((day.value / goal.target_value) * 100, 100);
                                    historyContent += `
                                        <div style="text-align: center; flex: 1;">
                                            <div style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">${day.day}</div>
                                            <div style="height: 100px; display: flex; align-items: flex-end; justify-content: center;">
                                                <div style="width: 20px; background: linear-gradient(to top, var(--teal), var(--aqua)); height: ${height}%; border-radius: 3px 3px 0 0;"></div>
                                            </div>
                                        </div>
                                    `;
                                });
                                historyContent += '</div>';
                            } else {
                                historyContent += '<div class="trend-chart" style="display: flex; justify-content: space-between; margin-top: 15px; margin-bottom: 5px;">';
                                const days = Array(7).fill(0).map((_, i) => {
                                    const date = new Date();
                                    date.setDate(date.getDate() - i);
                                    const entry = data.history.find(h => new Date(h.date).toDateString() === date.toDateString());
                                    return {
                                        day: date.toLocaleDateString('en-US', {
                                            weekday: 'short'
                                        }),
                                        value: entry ? entry.current_value : 0
                                    };
                                }).reverse();
                                days.forEach(day => {
                                    const height = Math.min((day.value / goal.target_value) * 100, 100);
                                    historyContent += `
                                        <div style="text-align: center; flex: 1;">
                                            <div style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">${day.day}</div>
                                            <div style="height: 100px; display: flex; align-items: flex-end; justify-content: center;">
                                                <div style="width: 20px; background: linear-gradient(to top, var(--teal), var(--aqua)); height: ${height}%; border-radius: 3px 3px 0 0;"></div>
                                            </div>
                                        </div>
                                    `;
                                });
                                historyContent += '</div>';
                            }
                        }
                        historyContent += '</div>';
                        modal.innerHTML = historyContent;
                        document.body.appendChild(modal);
                        modal.querySelector('.close').addEventListener('click', () => modal.remove());
                    });
            }

            function startMeditationSession(goalId, goalCard) {
                let secondsLeft = 600; // 10 minutes
                const modal = document.createElement('div');
                modal.className = 'modal';
                modal.innerHTML = `
                    <div class="modal-content">
                        <span class="close">×</span>
                        <h3>Meditation Session</h3>
                        <div class="timer-display">10:00</div>
                        <div class="goal-progress">
                            <div class="progress-label">Progress: <span id="timerProgress">0/10 minutes</span></div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 0%"></div>
                            </div>
                        </div>
                        <div class="goal-actions">
                            <button class="btn btn-primary" id="startTimer"><i class="fas fa-play"></i> Start</button>
                            <button class="btn btn-secondary" id="cancelTimer"><i class="fas fa-times"></i> Cancel</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                const timerDisplay = modal.querySelector('.timer-display');
                const progressText = modal.querySelector('#timerProgress');
                const progressBar = modal.querySelector('.progress-fill');
                let timer;

                function updateTimer() {
                    const minutes = Math.floor(secondsLeft / 60);
                    const seconds = secondsLeft % 60;
                    timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                    const progress = 600 - secondsLeft;
                    const percent = Math.min(Math.round((progress / 600) * 100), 100);
                    progressText.textContent = `${Math.floor(progress / 60)}/10 minutes`;
                    progressBar.style.width = `${percent}%`;
                }
                modal.querySelector('#startTimer').addEventListener('click', () => {
                    if (timer) return;
                    modal.querySelector('#startTimer').disabled = true;
                    timer = setInterval(() => {
                        secondsLeft--;
                        updateTimer();
                        if (secondsLeft <= 0) {
                            clearInterval(timer);
                            updateGoalProgress(goalId, 10).then(() => {
                                timerDisplay.textContent = 'Session Complete!';
                                setTimeout(() => {
                                    modal.remove();
                                    loadTabContent('mental');
                                }, 2000);
                            });
                        }
                    }, 1000);
                });
                modal.querySelector('#cancelTimer').addEventListener('click', () => {
                    if (timer) clearInterval(timer);
                    modal.remove();
                    const progress = 600 - secondsLeft;
                    if (progress > 0) {
                        updateGoalProgress(goalId, Math.floor(progress / 60)).then(() => loadTabContent('mental'));
                    }
                });
                modal.querySelector('.close').addEventListener('click', () => {
                    if (timer) clearInterval(timer);
                    modal.remove();
                    const progress = 600 - secondsLeft;
                    if (progress > 0) {
                        updateGoalProgress(goalId, Math.floor(progress / 60)).then(() => loadTabContent('mental'));
                    }
                });
                updateTimer();
            }
        });
    </script>
</body>

</html>