<!DOCTYPE html>
<html lang="en">
<?php include 'auth.php';?>
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

        .goal-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
        }

        .goal-card:hover::before {
            opacity: 1;
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
            width: 0%;
            transition: width 1s ease-in-out;
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

        .checkbox-label {
            flex: 1;
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

        ::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .animated-icon {
            animation: pulse 2s infinite;
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

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
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
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Wellness Goal Tracker</h1>
            <div class="date-display" id="currentDate">Loading date...</div>
        </header>
        <div class="tabs">
            <div class="tab active" data-tab="mental">Mental Wellness</div>
            <div class="tab" data-tab="nutrition">Nutrition</div>
            <div class="tab" data-tab="custom">Custom Goals</div>
            <div class="tab" data-tab="habits">Habit Building</div>
        </div>
        <div class="tab-content active" id="mental"></div>
        <div class="tab-content" id="nutrition"></div>
        <div class="tab-content" id="custom">
            <div class="goal-card">
                <div class="goal-title">
                    <h3>Create New Goal</h3>
                </div>
                <div class="form-group">
                    <label for="newGoalTitle">Goal Title</label>
                    <input type="text" id="newGoalTitle" placeholder="Enter goal title">
                </div>
                <div class="form-group">
                    <label for="newGoalDesc">Description</label>
                    <textarea id="newGoalDesc" rows="2" placeholder="Describe your goal"></textarea>
                </div>
                <div class="form-group">
                    <label for="goalType">Goal Type</label>
                    <select id="goalType">
                        <option value="count">Counter (track numbers)</option>
                        <option value="check">Checkbox (yes/no completion)</option>
                        <option value="streak">Streak (continuous days)</option>
                    </select>
                </div>
                <div class="goal-actions">
                    <button class="btn btn-primary" id="createGoalBtn"><i class="fas fa-plus"></i> Create Goal</button>
                </div>
            </div>
        </div>
        <div class="tab-content" id="habits"></div>
    </div>
    <script>
        // Update date display
        function updateDate() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
        }
        updateDate();

        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                tab.classList.add('active');
                const tabName = tab.getAttribute('data-tab');
                document.getElementById(tabName).classList.add('active');
                animateProgressBars();
            });
        });

        // Animate progress bars
        function animateProgressBars() {
            const visibleTab = document.querySelector('.tab-content.active');
            const progressBars = visibleTab.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        }

        // Load goals from backend
        async function loadGoals() {
            try {
                const response = await fetch('load_goals.php');
                const data = await response.json();
                if (data.success) {
                    renderGoals(data.goals);
                } else {
                    console.error('Error loading goals:', data.message);
                }
            } catch (error) {
                console.error('Fetch error:', error);
            }
        }

        // Render goals to the UI
        function renderGoals(goals) {
            const tabs = ['mental', 'nutrition', 'custom', 'habits'];
            tabs.forEach(tab => {
                document.getElementById(tab).innerHTML = '';
            });

            goals.forEach(goal => {
                const tabContent = document.getElementById(goal.category);
                const goalCard = document.createElement('div');
                goalCard.className = 'goal-card';
                let progressHtml = '';
                let actionsHtml = '';

                if (goal.goal_type === 'count') {
                    const [current, total] = goal.progress.split('/').map(s => s.trim());
                    const percentage = (parseInt(current) / parseInt(total)) * 100;
                    progressHtml = `
                        <div class="goal-progress">
                            <div class="progress-label">Progress: <span>${goal.progress}</span></div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${percentage}%"></div>
                            </div>
                        </div>
                    `;
                    actionsHtml = `
                        <div class="goal-actions">
                            <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Progress</button>
                            <button class="btn btn-secondary"><i class="fas fa-chart-line"></i> View Trends</button>
                        </div>
                    `;
                } else if (goal.goal_type === 'check') {
                    progressHtml = `
                        <div class="checkbox-wrapper">
                            <div class="custom-checkbox"></div>
                            <div class="checkbox-label">Completed today</div>
                        </div>
                    `;
                    actionsHtml = `
                        <div class="goal-actions">
                            <button class="btn btn-secondary"><i class="fas fa-play"></i> Guided Routine</button>
                        </div>
                    `;
                } else if (goal.goal_type === 'streak') {
                    const [current, total] = goal.progress.split('/').map(s => s.trim());
                    const percentage = (parseInt(current) / parseInt(total)) * 100;
                    progressHtml = `
                        <div class="goal-progress">
                            <div class="progress-label">Progress: <span>${goal.progress}</span></div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${percentage}%"></div>
                            </div>
                        </div>
                    `;
                    actionsHtml = `
                        <div class="goal-actions">
                            <button class="btn btn-primary"><i class="fas fa-check"></i> Mark Today Complete</button>
                        </div>
                    `;
                }

                goalCard.innerHTML = `
                    <div class="goal-title">
                        <h3>${goal.title}</h3>
                        <div class="streak-counter"><i class="fas fa-fire"></i> <span>${goal.streak} days</span></div>
                    </div>
                    <p>${goal.description}</p>
                    ${progressHtml}
                    ${actionsHtml}
                `;
                tabContent.insertBefore(goalCard, tabContent.firstChild);
            });

            // Reattach checkbox event listeners
            document.querySelectorAll('.custom-checkbox').forEach(checkbox => {
                checkbox.addEventListener('click', () => {
                    checkbox.classList.toggle('checked');
                    const ripple = document.createElement('span');
                    ripple.style.position = 'absolute';
                    ripple.style.width = '5px';
                    ripple.style.height = '5px';
                    ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
                    ripple.style.borderRadius = '50%';
                    ripple.style.transform = 'translate(-50%, -50%)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    const rect = checkbox.getBoundingClientRect();
                    ripple.style.left = event.clientX - rect.left + 'px';
                    ripple.style.top = event.clientY - rect.top + 'px';
                    checkbox.appendChild(ripple);
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Reattach button event listeners
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const button = e.currentTarget;
                    button.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        button.style.transform = '';
                    }, 200);
                });
            });

            // Reattach card hover effects
            document.querySelectorAll('.goal-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    const icons = card.querySelectorAll('i');
                    icons.forEach(icon => {
                        icon.classList.add('animated-icon');
                    });
                });
                card.addEventListener('mouseleave', () => {
                    const icons = card.querySelectorAll('i');
                    icons.forEach(icon => {
                        icon.classList.remove('animated-icon');
                    });
                });
            });

            animateProgressBars();
        }

        // Create new goal
        document.getElementById('createGoalBtn').addEventListener('click', async () => {
            const title = document.getElementById('newGoalTitle').value;
            const description = document.getElementById('newGoalDesc').value;
            const goalType = document.getElementById('goalType').value;

            if (!title || !description) {
                alert('Please fill in all fields');
                return;
            }

            const goalData = {
                userid: <?=$_SESSION['user_id'];?>,
                title,
                description,
                goal_type: goalType,
                category: 'custom',
                progress: goalType === 'count' ? '0/5' : goalType === 'streak' ? '0/30' : '0',
                streak: 0
            };

            try {
                const response = await fetch('goal_submit.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(goalData)
                });
                const data = await response.json();
                if (data.success) {
                    document.getElementById('newGoalTitle').value = '';
                    document.getElementById('newGoalDesc').value = '';
                    loadGoals(); // Refresh goals
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                alert('Fetch error: ' + error.message);
            }
        });

        // Initial load
        loadGoals();
    </script>
</body>
</html>