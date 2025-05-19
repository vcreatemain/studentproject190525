
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
        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        input:focus, textarea:focus, select:focus {
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
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        @keyframes ripple {
            0% { transform: scale(0); opacity: 1; }
            100% { transform: scale(10); opacity: 0; }
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
        <div class="tab-content active" id="mental">
            <div class="goal-card">
                <div class="goal-title">
                    <h3>Daily Meditation</h3>
                    <div class="streak-counter"><i class="fas fa-fire"></i> <span>5 days</span></div>
                </div>
                <p>Take 10 minutes each day to meditate and clear your mind</p>
                <div class="goal-progress">
                    <div class="progress-label">Progress: <span>7/10 minutes today</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 70%"></div>
                    </div>
                </div>
                <div class="goal-actions">
                    <button class="btn btn-primary"><i class="fas fa-play"></i> Start Session</button>
                    <button class="btn btn-secondary"><i class="fas fa-history"></i> History</button>
                </div>
            </div>
            <div class="goal-card">
                <div class="goal-title">
                    <h3>Mindfulness Practice</h3>
                    <div class="streak-counter"><i class="fas fa-fire"></i> <span>3 days</span></div>
                </div>
                <p>Be present and mindful during daily activities</p>
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox checked"></div>
                    <div class="checkbox-label">Morning mindfulness (5 min)</div>
                </div>
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox"></div>
                    <div class="checkbox-label">Mindful eating during lunch</div>
                </div>
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox"></div>
                    <div class="checkbox-label">Evening reflection (5 min)</div>
                </div>
                <div class="goal-actions">
                    <button class="btn btn-secondary"><i class="fas fa-plus"></i> Add Activity</button>
                </div>
            </div>
        </div>
        <div class="tab-content" id="nutrition">
            <div class="goal-card">
                <div class="goal-title">
                    <h3>Fruits & Vegetables</h3>
                    <div class="streak-counter"><i class="fas fa-fire"></i> <span>7 days</span></div>
                </div>
                <p>Eat 5 servings of fruits/vegetables daily</p>
                <div class="goal-progress">
                    <div class="progress-label">Progress: <span>3/5 servings today</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 60%"></div>
                    </div>
                </div>
                <div class="goal-actions">
                    <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Serving</button>
                    <button class="btn btn-secondary"><i class="fas fa-chart-line"></i> View Trends</button>
                </div>
            </div>
            <div class="goal-card">
                <div class="goal-title">
                    <h3>Limit Sugar Intake</h3>
                </div>
                <p>Reduce daily consumption of added sugars</p>
                <div class="goal-progress">
                    <div class="progress-label">Progress: <span>15g/25g limit today</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 60%"></div>
                    </div>
                </div>
                <div class="goal-actions">
                    <button class="btn btn-primary"><i class="fas fa-utensils"></i> Log Food</button>
                </div>
            </div>
            <div class="goal-card">
                <div class="goal-title">
                    <h3>Macro Tracking</h3>
                </div>
                <p>Balance proteins, fats, and carbohydrates</p>
                <div class="goal-progress">
                    <div class="progress-label">Protein: <span>45g/120g</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 37%"></div>
                    </div>
                </div>
                <div class="goal-progress">
                    <div class="progress-label">Carbs: <span>95g/200g</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 47%"></div>
                    </div>
                </div>
                <div class="goal-progress">
                    <div class="progress-label">Fats: <span>22g/60g</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 36%"></div>
                    </div>
                </div>
                <div class="goal-actions">
                    <button class="btn btn-primary"><i class="fas fa-utensils"></i> Log Meal</button>
                    <button class="btn btn-secondary"><i class="fas fa-cog"></i> Adjust Targets</button>
                </div>
            </div>
        </div>
        <div class="tab-content" id="custom">
            <div class="goal-card">
                <div class="goal-title">
                    <h3>No Soda Challenge</h3>
                    <div class="streak-counter"><i class="fas fa-fire"></i> <span>12 days</span></div>
                </div>
                <p>Avoid all soda for 30 days</p>
                <div class="goal-progress">
                    <div class="progress-label">Progress: <span>12/30 days complete</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 40%"></div>
                    </div>
                </div>
                <div class="goal-actions">
                    <button class="btn btn-primary"><i class="fas fa-check"></i> Mark Today Complete</button>
                </div>
            </div>
            <div class="goal-card">
                <div class="goal-title">
                    <h3>Morning Stretching</h3>
                </div>
                <p>Stretch for 5 minutes every morning</p>
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox"></div>
                    <div class="checkbox-label">Completed today</div>
                </div>
                <div class="goal-actions">
                    <button class="btn btn-secondary"><i class="fas fa-play"></i> Guided Routine</button>
                </div>
            </div>
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
                    <button class="btn btn-primary"><i class="fas fa-plus"></i> Create Goal</button>
                </div>
            </div>
        </div>
		<div class="tab-content" id="habits">
            <div class="goal-card">
                <div class="goal-title">
                    <h3>Habit Builder</h3>
                </div>
                <p>Track progress on building sustainable habits</p>
                
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox checked"></div>
                    <div class="checkbox-label">Drink water first thing in the morning <span class="streak-counter"><i class="fas fa-fire"></i> 8 days</span></div>
                </div>
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox checked"></div>
                    <div class="checkbox-label">Take the stairs instead of elevator <span class="streak-counter"><i class="fas fa-fire"></i> 5 days</span></div>
                </div>
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox"></div>
                    <div class="checkbox-label">Read for 15 minutes before bed <span class="streak-counter"><i class="fas fa-fire"></i> 0 days</span></div>
                </div>
                <div class="goal-actions">
                    <button class="btn btn-primary"><i class="fas fa-plus"></i> Add New Habit</button>
                </div>
            </div> 
            <div class="goal-card">
                <div class="goal-title">
                    <h3>Habit Progress Chart</h3>
                </div>
                <p>Your consistency over the past 4 weeks</p>
                <div style="display: flex; justify-content: space-between; margin-top: 15px; margin-bottom: 5px;">
                    <div style="text-align: center; flex: 1;">
                        <div style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">Week 1</div>
                        <div style="height: 100px; display: flex; align-items: flex-end; justify-content: center;">
                            <div style="width: 30px; background: linear-gradient(to top, var(--teal), var(--aqua)); height: 40%; border-radius: 3px 3px 0 0;"></div>
                        </div>
                    </div>
                    <div style="text-align:center; flex: 1;">
                        <div style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">Week 3</div>
                        <div style="height: 100px; display: flex; align-items: flex-end; justify-content: center;">
                            <div style="width: 30px; background: linear-gradient(to top, var(--teal), var(--aqua)); height: 55%; border-radius: 3px 3px 0 0;"></div>
                        </div>
                    </div>
                    <div style="text-align: center; flex: 1;">
                        <div style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">Week 4</div>
                        <div style="height: 100px; display: flex; align-items: flex-end; justify-content: center;">
                            <div style="width: 30px; background: linear-gradient(to top, var(--teal), var(--aqua)); height: 80%; border-radius: 3px 3px 0 0;"></div>
                        </div>
                    </div>
                </div>
                <div class="goal-actions">
                    <button class="btn btn-secondary"><i class="fas fa-chart-line"></i> Detailed Stats</button>
                </div>
            </div>
        </div>
    </div>
	<script>
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
        updateDate();
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
        animateProgressBars();
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
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const button = e.currentTarget;
                button.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    button.style.transform = '';
                }, 200);
                if (button.innerHTML.includes('Add Serving')) {
                    const card = button.closest('.goal-card');
                    const progressText = card.querySelector('.progress-label span');
                    const progressBar = card.querySelector('.progress-fill');
                    if (progressText.textContent === '3/5 servings today') {
                        progressText.textContent = '4/5 servings today';
                        progressBar.style.width = '80%';
                    } else if (progressText.textContent === '4/5 servings today') {
                        progressText.textContent = '5/5 servings today';
                        progressBar.style.width = '100%';
                    }
                }
                if (button.innerHTML.includes('Mark Today Complete')) {
                    const card = button.closest('.goal-card');
                    const streakCounter = card.querySelector('.streak-counter span');
                    if (streakCounter.textContent === '12 days') {
                        streakCounter.textContent = '13 days';
                        const progressText = card.querySelector('.progress-label span');
                        const progressBar = card.querySelector('.progress-fill');
                        progressText.textContent = '13/30 days complete';
                        progressBar.style.width = '43%';
                    }
                }
            });
        });
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
</script></body></html>