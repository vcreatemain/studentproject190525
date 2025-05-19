<?php

include 'auth.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Matrix Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #2ecc71;
            --light-bg: #ecf0f1;
            --border-radius: 12px;
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #e0f7fa, #b3e5fc);
            color: var(--primary-color);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            border-radius: var(--border-radius);
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.8), rgba(52, 152, 219, 0.8));
            color: white;
            box-shadow: var(--card-shadow);
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            animation: fadeIn 1s ease;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .card {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0f7fa;
            color: var(--secondary-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary-color);
        }

        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .form-row .form-group {
            flex: 1;
            min-width: 200px;
            margin-bottom: 0;
        }

        button {
            background: linear-gradient(to right, var(--secondary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: block;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(46, 204, 113, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .dashboard {
            display: none;
        }

        .widget {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            animation: fadeIn 0.5s ease;
        }

        .widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .widget-header {
            font-size: 1.3rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0f7fa;
            color: var(--secondary-color);
        }

        .widget-body {
            position: relative;
        }

        .stat-card {
            background: linear-gradient(135deg, #e0f7fa, #b3e5fc);
            border-radius: var(--border-radius);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow);
        }

        .stat-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--secondary-color);
        }

        .stat-badge {
            background: rgba(46, 204, 113, 0.2);
            color: var(--accent-color);
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 50px;
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 300px;
            margin-bottom: 20px;
        }

        .meal-card {
            background: rgba(236, 240, 241, 0.5);
            border-radius: var(--border-radius);
            padding: 15px;
            margin-bottom: 15px;
        }

        .meal-title {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .meal-items {
            padding-left: 20px;
        }

        .meal-item {
            margin-bottom: 5px;
        }

        .recommendation {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(46, 204, 113, 0.1);
            border-radius: var(--border-radius);
            border-left: 4px solid var(--accent-color);
        }

        .recommendation-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            background: var(--accent-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 20px;
        }

        .recommendation-content {
            flex-grow: 1;
        }

        .recommendation-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .recommendation-text {
            font-size: 0.9rem;
            color: #555;
        }

        .progress-container {
            height: 10px;
            background: #ecf0f1;
            border-radius: 5px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, var(--secondary-color), var(--accent-color));
            border-radius: 5px;
            width: 0;
            transition: width 1s ease;
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: var(--border-radius);
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 2rem;
            color: white;
            font-weight: bold;
        }

        .user-details h2 {
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .user-meta {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: white;
            border-radius: var(--border-radius);
            padding: 15px 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            transform: translateX(calc(100% + 30px));
            transition: transform 0.3s ease;
            z-index: 1000;
            max-width: 350px;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            background: var(--secondary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
        }

        .notification-content {
            flex-grow: 1;
        }

        .notification-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .notification-text {
            font-size: 0.9rem;
            color: #555;
        }

        .notification-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 18px;
            color: #7f8c8d;
            cursor: pointer;
            width: auto;
            margin: 0;
            padding: 0;
            box-shadow: none;
        }

        .notification-close:hover {
            color: var(--primary-color);
            transform: none;
            box-shadow: none;
        }

        .meal-form {
            margin-top: 20px;
        }

        .meal-form-header {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ecf0f1;
            color: var(--secondary-color);
        }

        .add-food-btn {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: var(--border-radius);
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
            width: auto;
            display: inline-block;
        }

        .add-food-btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .food-items {
            margin-bottom: 15px;
        }

        .food-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .food-item input {
            flex-grow: 1;
        }

        .food-item button {
            background: #e74c3c;
            width: auto;
            margin: 0;
            padding: 8px;
            font-size: 14px;
        }

        .water-tracker {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 15px;
        }

        .water-glass {
            width: 30px;
            height: 40px;
            border-radius: 5px 5px 10px 10px;
            border: 2px solid var(--secondary-color);
            position: relative;
            overflow: hidden;
            margin-right: 10px;
        }

        .water-level {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #3498db;
            transition: height 0.3s ease;
        }

        .water-counter {
            font-weight: 600;
            color: var(--secondary-color);
        }

        .water-add {
            background: var(--secondary-color);
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 5px rgba(52, 152, 219, 0.3);
            padding: 0;
            margin: 0;
        }

        .water-add:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.4);
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

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 10px;
        }

        .badge-good {
            background-color: rgba(46, 204, 113, 0.2);
            color: #27ae60;
        }

        .badge-warning {
            background-color: rgba(241, 196, 15, 0.2);
            color: #f39c12;
        }

        .badge-danger {
            background-color: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid #ecf0f1;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: var(--transition);
            color: #7f8c8d;
        }

        .tab.active {
            border-color: var(--secondary-color);
            color: var(--secondary-color);
            font-weight: 600;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                flex-direction: column;
                gap: 10px;
            }
            
            .form-row .form-group {
                margin-bottom: 10px;
            }
            
            .user-profile {
                flex-direction: column;
                text-align: center;
            }
            
            .user-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }
        }

        /* Food logging specific styles */
        .food-log-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .food-log-table th, .food-log-table td {
            padding: 10px;
            border-bottom: 1px solid #ecf0f1;
            text-align: left;
        }

        .food-log-table th {
            color: var(--secondary-color);
            font-weight: 600;
        }

        .food-log-summary {
            margin-top: 20px;
            padding: 15px;
            background: rgba(52, 152, 219, 0.1);
            border-radius: var(--border-radius);
        }

        .macro-progress {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .macro-label {
            width: 100px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .macro-bar {
            flex-grow: 1;
            height: 8px;
            background: #ecf0f1;
            border-radius: 4px;
            overflow: hidden;
            margin: 0 15px;
        }

        .macro-value {
            width: 60px;
            text-align: right;
            font-weight: 600;
            color: var(--secondary-color);
        }

        .protein-fill {
            height: 100%;
            background: #3498db;
            width: 0;
            transition: width 1s ease;
        }

        .carbs-fill {
            height: 100%;
            background: #2ecc71;
            width: 0;
            transition: width 1s ease;
        }

        .fat-fill {
            height: 100%;
            background: #f39c12;
            width: 0;
            transition: width 1s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Health Matrix Dashboard</h1>
            <p>Track your health metrics and get personalized recommendations</p>
        </div>

        <!-- User Registration Form -->
        <div class="card" id="registration-form">
            <h2 class="card-header">Enter Your Details</h2>
            <form id="user-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" placeholder="Enter your age" min="1" max="120" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="height">Height (cm)</label>
                        <input type="number" id="height" name="height" placeholder="Enter your height in cm" min="50" max="250" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="number" id="weight" name="weight" placeholder="Enter your weight in kg" min="1" max="300" required>
                    </div>
                    <div class="form-group">
                        <label for="oxygen">Oxygen Level (%)</label>
                        <input type="number" id="oxygen" name="oxygen" placeholder="Enter your oxygen level" min="50" max="100" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="systolic">Systolic Blood Pressure (mmHg)</label>
                        <input type="number" id="systolic" name="systolic" placeholder="Enter systolic pressure" min="70" max="250" required>
                    </div>
                    <div class="form-group">
                        <label for="diastolic">Diastolic Blood Pressure (mmHg)</label>
                        <input type="number" id="diastolic" name="diastolic" placeholder="Enter diastolic pressure" min="40" max="150" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="steps">Steps Walked Today</label>
                    <input type="number" id="steps" name="steps" placeholder="Enter steps walked" min="0" required>
                </div>
                
                <button type="submit">Generate Health Dashboard</button>
            </form>
        </div>

        <!-- Dashboard - Hidden by default -->
        <div class="dashboard" id="health-dashboard">
            <!-- User Profile -->
            <div class="user-profile">
                <div class="user-avatar" id="user-initial"></div>
                <div class="user-details">
                    <h2 id="user-name">User Name</h2>
                    <div class="user-meta">
                        <span id="user-age-gender">30 years, Male</span> • 
                        <span id="user-height-weight">175 cm, 70 kg</span>
                    </div>
                </div>
            </div>

            <!-- Health Metrics Summary -->
            <div class="grid">
                <div class="widget">
                    <h3 class="widget-header">Health Metrics</h3>
                    <div class="widget-body">
                        <div class="stat-card">
                            <div>
                                <div class="stat-title">BMI (Body Mass Index)</div>
                                <div class="stat-value" id="bmi-value">22.5</div>
                            </div>
                            <div class="stat-badge" id="bmi-status">Normal</div>
                        </div>

                        <div class="stat-card">
                            <div>
                                <div class="stat-title">BMR (Basal Metabolic Rate)</div>
                                <div class="stat-value" id="bmr-value">1650</div>
                            </div>
                            <div class="stat-badge">Calories/day</div>
                        </div>

                        <div class="stat-card">
                            <div>
                                <div class="stat-title">Blood Pressure</div>
                                <div class="stat-value" id="bp-value">120/80</div>
                            </div>
                            <div class="stat-badge" id="bp-status">Normal</div>
                        </div>

                        <div class="stat-card">
                            <div>
                                <div class="stat-title">Blood Oxygen Level</div>
                                <div class="stat-value" id="oxygen-value">98%</div>
                            </div>
                            <div class="stat-badge" id="oxygen-status">Excellent</div>
                        </div>

                        <div class="stat-card">
                            <div>
                                <div class="stat-title">Steps Today</div>
                                <div class="stat-value" id="steps-value">8,567</div>
                            </div>
                            <div class="stat-badge" id="steps-status">Active</div>
                        </div>
                    </div>
                </div>

                <div class="widget">
                    <h3 class="widget-header">Daily Activity</h3>
                    <div class="tabs">
                        <div class="tab active" data-tab="steps">Steps</div>
                        <div class="tab" data-tab="calories">Calories</div>
                        <div class="tab" data-tab="water">Water</div>
                    </div>
                    <div class="tab-content active" id="steps-tab">
                        <div class="chart-container">
                            <canvas id="steps-chart"></canvas>
                        </div>
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>👟</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Walking Recommendation</div>
                                <div class="recommendation-text" id="steps-recommendation">
                                    You're on track! Try to reach 10,000 steps daily for optimal health.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="calories-tab">
                        <div class="chart-container">
                            <canvas id="calories-chart"></canvas>
                        </div>
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>🔥</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Caloric Balance</div>
                                <div class="recommendation-text" id="calories-recommendation">
                                    Based on your BMR, you should consume around 1800-2000 calories for weight maintenance.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="water-tab">
                        <div class="chart-container">
                            <canvas id="water-chart"></canvas>
                        </div>
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>💧</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Water Intake</div>
                                <div class="recommendation-text" id="water-recommendation">
                                    Aim to drink 2.5-3 liters of water daily for proper hydration.
                                </div>
                            </div>
                        </div>
                        <div class="water-tracker">
                            <div style="display: flex; align-items: center;">
                                <div class="water-glass">
                                    <div class="water-level" style="height: 30%;"></div>
                                </div>
                                <div class="water-counter">2/8 glasses</div>
                            </div>
                            <button class="water-add">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid">
                <div class="widget">
                    <h3 class="widget-header">Nutrition Summary</h3>
                    <div class="chart-container">
                        <canvas id="nutrition-chart"></canvas>
                    </div>
                    <div class="food-log-summary">
                        <h4>Macronutrient Progress</h4>
                        <div class="macro-progress">
                            <div class="macro-label">Protein</div>
                            <div class="macro-bar">
                                <div class="protein-fill" style="width: 60%;"></div>
                            </div>
                            <div class="macro-value">60g / 100g</div>
                        </div>
                        <div class="macro-progress">
                            <div class="macro-label">Carbs</div>
                            <div class="macro-bar">
                                <div class="carbs-fill" style="width: 70%;"></div>
                            </div>
                            <div class="macro-value">175g / 250g</div>
                        </div>
                        <div class="macro-progress">
                            <div class="macro-label">Fats</div>
                            <div class="macro-bar">
                                <div class="fat-fill" style="width: 45%;"></div>
                            </div>
                            <div class="macro-value">30g / 65g</div>
                        </div>
                    </div>
                </div>

                <div class="widget">
                    <h3 class="widget-header">Meal Logging</h3>
                    <div class="tabs">
                        <div class="tab active" data-tab="log-meal">Log Food</div>
                        <div class="tab" data-tab="meal-history">Today's Meals</div>
                    </div>
                    <div class="tab-content active" id="log-meal-tab">
                        <div class="meal-form">
                            <div class="form-group">
                                <label for="meal-type">Meal Type</label>
                                <select id="meal-type">
                                    <option value="breakfast">Breakfast</option>
                                    <option value="lunch">Lunch</option>
                                    <option value="dinner">Dinner</option>
                                    <option value="snack">Snack</option>
                                </select>
                            </div>
                            <div class="food-items" id="food-items-container">
                                <div class="food-item">
                                    <input type="text" placeholder="Food item" class="food-name">
                                    <input type="number" placeholder="Calories" class="food-calories" min="0">
                                    <input type="number" placeholder="Portion (g)" class="food-portion" min="0">
                                    <button type="button" class="food-remove">×</button>
                                </div>
                            </div>
                            <button type="button" class="add-food-btn" id="add-food-item">+ Add Food Item</button>
                            <button type="button" id="save-meal">Save Meal</button>
                        </div>
                    </div>
                    <div class="tab-content" id="meal-history-tab">
                        <div class="food-log-table-wrapper">
                            <table class="food-log-table">
                                <thead>
                                    <tr>
                                        <th>Meal</th>
                                        <th>Food</th>
                                        <th>Calories</th>
                                        <th>Portion</th>
                                    </tr>
                                </thead>
                                <tbody id="meal-history-table">
                                    <!-- Meal history will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget">
                <h3 class="widget-header">Nutrition Recommendations</h3>
                <div class="tabs">
                    <div class="tab active" data-tab="meal-plans">Meal Plans</div>
                    <div class="tab" data-tab="supplements">Supplements</div>
                </div>
                <div class="tab-content active" id="meal-plans-tab">
                    <div class="meal-card">
                        <h4 class="meal-title">Breakfast Options</h4>
                        <ul class="meal-items">
                            <li class="meal-item">Oatmeal with berries and nuts (300 cal)</li>
                            <li class="meal-item">Greek yogurt with honey and fruits (250 cal)</li>
                            <li class="meal-item">Whole grain toast with avocado and eggs (400 cal)</li>
                            <li class="meal-item">Protein smoothie with spinach, banana, and almond milk (350 cal)</li>
                        </ul>
                    </div>
                    <div class="meal-card">
                        <h4 class="meal-title">Lunch Options</h4>
                        <ul class="meal-items">
                            <li class="meal-item">Quinoa salad with grilled chicken and vegetables (450 cal)</li>
                            <li class="meal-item">Lentil soup with whole grain bread (400 cal)</li>
                            <li class="meal-item">Salmon with steamed vegetables and brown rice (500 cal)</li>
                            <li class="meal-item">Mediterranean wrap with hummus and vegetables (420 cal)</li>
                        </ul>
                    </div>
                    <div class="meal-card">
                        <h4 class="meal-title">Dinner Options</h4>
                        <ul class="meal-items">
                            <li class="meal-item">Grilled fish with roasted vegetables (380 cal)</li>
                            <li class="meal-item">Stir-fried tofu with vegetables and brown rice (420 cal)</li>
                            <li class="meal-item">Baked chicken breast with sweet potato and broccoli (450 cal)</li>
                            <li class="meal-item">Vegetable and bean chili with a small side salad (400 cal)</li>
                        </ul>
                    </div>
                    <div class="meal-card">
                        <h4 class="meal-title">Healthy Snacks</h4>
                        <ul class="meal-items">
                            <li class="meal-item">Mixed nuts and seeds (160 cal per 1/4 cup)</li>
                            <li class="meal-item">Apple with almond butter (200 cal)</li>
                            <li class="meal-item">Carrot sticks with hummus (150 cal)</li>
                            <li class="meal-item">Greek yogurt with berries (120 cal)</li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="supplements-tab">
                    <div class="recommendation">
                        <div class="recommendation-icon">
                            <i>💊</i>
                        </div>
                        <div class="recommendation-content">
                            <div class="recommendation-title">Vitamin D</div>
                            <div class="recommendation-text">
                                Important for bone health and immune function. Recommended especially if you have limited sun exposure.
                            </div>
                        </div>
                    </div>
                    <div class="recommendation">
                        <div class="recommendation-icon">
                            <i>💊</i>
                        </div>
                        <div class="recommendation-content">
                            <div class="recommendation-title">Omega-3 Fatty Acids</div>
                            <div class="recommendation-text">
                                Supports heart and brain health. Consider if you consume limited fatty fish.
                            </div>
                        </div>
                    </div>
                    <div class="recommendation">
                        <div class="recommendation-icon">
                            <i>💊</i>
                        </div>
                        <div class="recommendation-content">
                            <div class="recommendation-title">Magnesium</div>
                            <div class="recommendation-text">
                                Important for muscle function and energy production. Consider if you experience muscle cramps or fatigue.
                            </div>
                        </div>
                    </div>
                    <div class="recommendation">
                        <div class="recommendation-icon">
                            <i>🍎</i>
                        </div>
                        <div class="recommendation-content">
                            <div class="recommendation-title">Multivitamin</div>
                            <div class="recommendation-text">
                                A general multivitamin can help fill nutritional gaps in your diet. Choose one with 100% DV of most vitamins and minerals.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid">
                <div class="widget">
                    <h3 class="widget-header">Exercise Recommendations</h3>
                    <div class="tabs">
                        <div class="tab active" data-tab="cardio">Cardio</div>
                        <div class="tab" data-tab="strength">Strength</div>
                        <div class="tab" data-tab="flexibility">Flexibility</div>
                    </div>
                    <div class="tab-content active" id="cardio-tab">
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>🏃</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Walking</div>
                                <div class="recommendation-text">
                                    Aim for 10,000 steps daily. Walking is low-impact and excellent for cardiovascular health.
                                </div>
                            </div>
                        </div>
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>🚴</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Cycling</div>
                                <div class="recommendation-text">
                                    15-30 minutes, 3-5 times per week. Great for leg strength and cardiovascular fitness.
                                </div>
                            </div>
                        </div>
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>🏊</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Swimming</div>
                                <div class="recommendation-text">
                                    20-30 minutes, 2-3 times per week. Full-body workout with minimal joint impact.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="strength-tab">
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>💪</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Body Weight Exercises</div>
                                <div class="recommendation-text">
                                    Push-ups, squats, lunges - 2-3 sets of 10-15 reps, 2-3 times per week.
                                </div>
                            </div>
                        </div>
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>🏋️</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Weight Training</div>
                                <div class="recommendation-text">
                                    Focus on major muscle groups, 2-3 times per week with rest days in between.
                                </div>
                            </div>
                        </div>
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>⚡</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Core Strengthening</div>
                                <div class="recommendation-text">
                                    Planks, bridges, and abdominal exercises, 10-15 minutes daily.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="flexibility-tab">
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>🧘</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Yoga</div>
                                <div class="recommendation-text">
                                    15-30 minutes, 2-3 times per week. Improves flexibility, balance, and mental well-being.
                                </div>
                            </div>
                        </div>
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>🤸</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Stretching Routine</div>
                                <div class="recommendation-text">
                                    5-10 minutes daily, focusing on major muscle groups. Hold each stretch for 15-30 seconds.
                                </div>
                            </div>
                        </div>
                        <div class="recommendation">
                            <div class="recommendation-icon">
                                <i>🧠</i>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Mobility Exercises</div>
                                <div class="recommendation-text">
                                    Joint mobility exercises, 5 minutes daily, especially for shoulders, hips, and ankles.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget">
                    <h3 class="widget-header">Sleep Quality</h3>
                    <div class="chart-container">
                        <canvas id="sleep-chart"></canvas>
                    </div>
                    <div class="recommendation">
                        <div class="recommendation-icon">
                            <i>😴</i>
                        </div>
                        <div class="recommendation-content">
                            <div class="recommendation-title">Sleep Recommendation</div>
                            <div class="recommendation-text" id="sleep-recommendation">
                                Aim for 7-9 hours of quality sleep each night. Maintain a consistent sleep schedule even on weekends.
                            </div>
                        </div>
                    </div>
                    <div class="recommendation">
                        <div class="recommendation-icon">
                            <i>🌙</i>
                        </div>
                        <div class="recommendation-content">
                            <div class="recommendation-title">Sleep Hygiene Tips</div>
                            <div class="recommendation-text">
                                Limit screen time before bed, keep your bedroom cool and dark, and avoid caffeine late in the day.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Water reminder notification -->
        <div class="notification" id="water-notification">
            <div class="notification-icon">
                <i>💧</i>
            </div>
            <div class="notification-content">
                <div class="notification-title">Water Reminder</div>
                <div class="notification-text">Time to drink a glass of water! Stay hydrated for optimal health.</div>
            </div>
            <button class="notification-close">&times;</button>
        </div>
    </div>

    <script>
        // DOM Elements
        const userForm = document.getElementById('user-form');
        const registrationForm = document.getElementById('registration-form');
        const healthDashboard = document.getElementById('health-dashboard');
        const waterNotification = document.getElementById('water-notification');
        const closeNotification = document.querySelector('.notification-close');
        const addFoodBtn = document.getElementById('add-food-item');
        const foodItemsContainer = document.getElementById('food-items-container');
        const saveMealBtn = document.getElementById('save-meal');
        const mealHistoryTable = document.getElementById('meal-history-table');
        const waterAddBtn = document.querySelector('.water-add');
        const waterLevelEl = document.querySelector('.water-level');
        const waterCounterEl = document.querySelector('.water-counter');
        
        // Global variables
        let userData = {};
        let waterGlasses = 2;
        let maxWaterGlasses = 8;
        let mealLog = [];
        
        // Tab functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                const tabContainer = this.closest('.tabs').parentElement;
                
                // Remove active class from all tabs and contents in this container
                tabContainer.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tabContainer.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                tabContainer.querySelector(`#${tabName}-tab`).classList.add('active');
            });
        });
        
        // Handle form submission
        userForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Collect form data
            userData = {
                userid: '<?=$_SESSION['user_id'];?>',
                name: document.getElementById('name').value,
                age: parseInt(document.getElementById('age').value),
                gender: document.getElementById('gender').value,
                height: parseFloat(document.getElementById('height').value),
                weight: parseFloat(document.getElementById('weight').value),
                oxygen: parseInt(document.getElementById('oxygen').value),
                systolic: parseInt(document.getElementById('systolic').value),
                diastolic: parseInt(document.getElementById('diastolic').value),
                steps: parseInt(document.getElementById('steps').value)
            };
                sendDataToServer(userData);
            // Calculate health metrics
            calculateHealthMetrics();
            
            // Update dashboard with user data
            updateDashboard();
            
            // Hide registration form and show dashboard
            registrationForm.style.display = 'none';
            healthDashboard.style.display = 'block';
            
            // Initialize charts
            initCharts();
            
            // Set water reminder
            setWaterReminder();
        });
        function sendDataToServer(data) {
    fetch('submitdata.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
        // Calculate BMI, BMR and other health metrics
        function calculateHealthMetrics() {
            // Calculate BMI = weight(kg) / (height(m))²
            const heightInMeters = userData.height / 100;
            userData.bmi = userData.weight / (heightInMeters * heightInMeters);
            
            // Calculate BMR using Mifflin-St Jeor Equation
            if (userData.gender === 'male') {
                userData.bmr = 10 * userData.weight + 6.25 * userData.height - 5 * userData.age + 5;
            } else {
                userData.bmr = 10 * userData.weight + 6.25 * userData.height - 5 * userData.age - 161;
            }
            
            // Determine BMI status
            if (userData.bmi < 18.5) {
                userData.bmiStatus = 'Underweight';
                userData.bmiClass = 'badge-warning';
            } else if (userData.bmi < 25) {
                userData.bmiStatus = 'Normal';
                userData.bmiClass = 'badge-good';
            } else if (userData.bmi < 30) {
                userData.bmiStatus = 'Overweight';
                userData.bmiClass = 'badge-warning';
            } else {
                userData.bmiStatus = 'Obese';
                userData.bmiClass = 'badge-danger';
            }
            
            // Determine Blood Pressure status
            if (userData.systolic < 120 && userData.diastolic < 80) {
                userData.bpStatus = 'Normal';
                userData.bpClass = 'badge-good';
            } else if (userData.systolic < 130 && userData.diastolic < 80) {
                userData.bpStatus = 'Elevated';
                userData.bpClass = 'badge-warning';
            } else {
                userData.bpStatus = 'High';
                userData.bpClass = 'badge-danger';
            }
            
            // Determine Oxygen Level status
            if (userData.oxygen >= 95) {
                userData.oxygenStatus = 'Normal';
                userData.oxygenClass = 'badge-good';
            } else if (userData.oxygen >= 90) {
                userData.oxygenStatus = 'Slightly Low';
                userData.oxygenClass = 'badge-warning';
            } else {
                userData.oxygenStatus = 'Low';
                userData.oxygenClass = 'badge-danger';
            }
            
            // Determine Steps status
            if (userData.steps >= 10000) {
                userData.stepsStatus = 'Very Active';
                userData.stepsClass = 'badge-good';
            } else if (userData.steps >= 7500) {
                userData.stepsStatus = 'Active';
                userData.stepsClass = 'badge-good';
            } else if (userData.steps >= 5000) {
                userData.stepsStatus = 'Moderately Active';
                userData.stepsClass = 'badge-warning';
            } else {
                userData.stepsStatus = 'Sedentary';
                userData.stepsClass = 'badge-danger';
            }
        }
        
        // Update dashboard with user data
        function updateDashboard() {
            // Update user profile
            document.getElementById('user-name').textContent = userData.name;
            document.getElementById('user-initial').textContent = userData.name.charAt(0).toUpperCase();
            document.getElementById('user-age-gender').textContent = `${userData.age} years, ${userData.gender.charAt(0).toUpperCase() + userData.gender.slice(1)}`;
            document.getElementById('user-height-weight').textContent = `${userData.height} cm, ${userData.weight} kg`;
            
            // Update health metrics
            document.getElementById('bmi-value').textContent = userData.bmi.toFixed(1);
            document.getElementById('bmi-status').textContent = userData.bmiStatus;
            document.getElementById('bmi-status').className = `stat-badge ${userData.bmiClass}`;
            
            document.getElementById('bmr-value').textContent = Math.round(userData.bmr);
            
            document.getElementById('bp-value').textContent = `${userData.systolic}/${userData.diastolic}`;
            document.getElementById('bp-status').textContent = userData.bpStatus;
            document.getElementById('bp-status').className = `stat-badge ${userData.bpClass}`;
            
            document.getElementById('oxygen-value').textContent = `${userData.oxygen}%`;
            document.getElementById('oxygen-status').textContent = userData.oxygenStatus;
            document.getElementById('oxygen-status').className = `stat-badge ${userData.oxygenClass}`;
            
            document.getElementById('steps-value').textContent = userData.steps.toLocaleString();
            document.getElementById('steps-status').textContent = userData.stepsStatus;
            document.getElementById('steps-status').className = `stat-badge ${userData.stepsClass}`;
            
            // Update recommendations based on user data
            updateRecommendations();
        }
        
        // Update personalized recommendations
        function updateRecommendations() {
            // Steps recommendation
            const stepsRecommendation = document.getElementById('steps-recommendation');
            if (userData.steps < 5000) {
                stepsRecommendation.textContent = "Try to gradually increase your daily steps. Start by adding 1,000 steps per day this week.";
            } else if (userData.steps < 7500) {
                stepsRecommendation.textContent = "You're on a good track! Try to reach 7,500 steps daily for improved health.";
            } else if (userData.steps < 10000) {
                stepsRecommendation.textContent = "Great job! Try to reach 10,000 steps daily for optimal health benefits.";
            } else {
                stepsRecommendation.textContent = "Excellent! You've reached the recommended 10,000 steps. Keep up the good work!";
            }
            
            // Calories recommendation
            const caloriesRecommendation = document.getElementById('calories-recommendation');
            let activityMultiplier = 1.2; // Sedentary
            if (userData.steps >= 10000) {
                activityMultiplier = 1.725; // Very active
            } else if (userData.steps >= 7500) {
                activityMultiplier = 1.55; // Moderately active
            } else if (userData.steps >= 5000) {
                activityMultiplier = 1.375; // Lightly active
            }
            
            const tdee = Math.round(userData.bmr * activityMultiplier);
            caloriesRecommendation.textContent = `Based on your activity level, you need approximately ${tdee} calories daily for maintenance.`;
            
            // Water recommendation
            const waterRecommendation = document.getElementById('water-recommendation');
            const waterIntake = Math.round(userData.weight * 0.033); // 33ml per kg of body weight
            waterRecommendation.textContent = `Aim to drink about ${waterIntake} liters of water daily for optimal hydration.`;
            
            // Sleep recommendation
            const sleepRecommendation = document.getElementById('sleep-recommendation');
            if (userData.age < 18) {
                sleepRecommendation.textContent = "Teenagers need 8-10 hours of sleep for optimal health and development.";
            } else if (userData.age < 65) {
                sleepRecommendation.textContent = "Adults should aim for 7-9 hours of quality sleep each night.";
            } else {
                sleepRecommendation.textContent = "Older adults need 7-8 hours of sleep and may benefit from a short daytime nap.";
            }
        }
        
        // Initialize charts
        function initCharts() {
            // Steps Chart - Last 7 days
            const stepsCtx = document.getElementById('steps-chart').getContext('2d');
            const stepsData = [
                Math.round(userData.steps * 0.9),
                Math.round(userData.steps * 0.8),
                Math.round(userData.steps * 1.1),
                Math.round(userData.steps * 0.95),
                Math.round(userData.steps * 0.85),
                Math.round(userData.steps * 1.05),
                userData.steps
            ];
            
            const stepsChart = new Chart(stepsCtx, {
                type: 'line',
                data: {
                    labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Today'],
                    datasets: [{
                        label: 'Steps',
                        data: stepsData,
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#3498db'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Calories Chart
            const caloriesCtx = document.getElementById('calories-chart').getContext('2d');
            const activityMultiplier = userData.steps >= 7500 ? 1.55 : (userData.steps >= 5000 ? 1.375 : 1.2);
            const tdee = Math.round(userData.bmr * activityMultiplier);
            
            const caloriesChart = new Chart(caloriesCtx, {
                type: 'bar',
                data: {
                    labels: ['Consumed', 'Burned', 'Remaining'],
                    datasets: [{
                        label: 'Calories',
                        data: [1800, 400, tdee - 1800 + 400],
                        backgroundColor: [
                            'rgba(52, 152, 219, 0.7)',
                            'rgba(231, 76, 60, 0.7)',
                            'rgba(46, 204, 113, 0.7)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Water Intake Chart
            const waterCtx = document.getElementById('water-chart').getContext('2d');
            const waterChart = new Chart(waterCtx, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Glasses of Water',
                        data: [6, 5, 7, 8, 6, 4, 2],
                        backgroundColor: 'rgba(52, 152, 219, 0.7)',
                        borderWidth: 0,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 8,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Sleep Chart
            const sleepCtx = document.getElementById('sleep-chart').getContext('2d');
            const sleepChart = new Chart(sleepCtx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Hours of Sleep',
                        data: [7.5, 6.8, 7.2, 8.0, 7.5, 8.5, 7.8],
                        borderColor: '#9b59b6',
                        backgroundColor: 'rgba(155, 89, 182, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#9b59b6'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 5,
                            max: 10,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Nutrition Chart (Macronutrients)
            const nutritionCtx = document.getElementById('nutrition-chart').getContext('2d');
            const nutritionChart = new Chart(nutritionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Protein', 'Carbs', 'Fats'],
                    datasets: [{
                        data: [25, 50, 25],
                        backgroundColor: [
                            'rgba(52, 152, 219, 0.7)',
                            'rgba(46, 204, 113, 0.7)',
                            'rgba(241, 196, 15, 0.7)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    },
                    cutout: '70%'
                }
            });
        }
        
        // Set water reminder
        function setWaterReminder() {
            // Show water reminder every 30 minutes
            setInterval(() => {
                waterNotification.classList.add('show');
                
                // Hide notification after 10 seconds
                setTimeout(() => {
                    waterNotification.classList.remove('show');
                }, 10000);
            }, 1800000); // 30 minutes
            
            // For demo purposes, show the first notification after 5 seconds
        }
        </script>
        </body>
        </html>