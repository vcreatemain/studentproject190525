<?php include 'auth.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Chat Bot</title>
    <style>
        :root {
            --pastel-green: #a8e6cf;
            --pastel-green-light: #dcedc1;
            --pastel-blue: #b1d4e0;
            --pastel-blue-light: #d6eaf8;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --white: #ffffff;
            --shadow: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--pastel-blue-light) 0%, var(--pastel-green-light) 100%);
            color: var(--text-dark);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .chat-container {
            width: 100%;
            max-width: 400px;
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 600px;
        }

        .chat-header {
            padding: 20px;
            background: linear-gradient(to right, var(--pastel-green), var(--pastel-blue));
            color: var(--white);
            text-align: center;
            position: relative;
        }

        .chat-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .chat-subtitle {
            font-size: 12px;
            opacity: 0.8;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
            scroll-behavior: smooth;
        }

        .message {
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 18px;
            animation: fadeIn 0.3s ease;
            position: relative;
            line-height: 1.4;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.incoming {
            align-self: flex-start;
            background-color: var(--pastel-blue-light);
            border-bottom-left-radius: 4px;
            margin-left: 5px;
        }

        .message.incoming::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: -5px;
            width: 10px;
            height: 10px;
            background-color: var(--pastel-blue-light);
            border-bottom-right-radius: 10px;
        }

        .message.outgoing {
            align-self: flex-end;
            background-color: var(--pastel-green);
            border-bottom-right-radius: 4px;
            margin-right: 5px;
        }

        .message.outgoing::before {
            content: '';
            position: absolute;
            bottom: 0;
            right: -5px;
            width: 10px;
            height: 10px;
            background-color: var(--pastel-green);
            border-bottom-left-radius: 10px;
        }

        .message-time {
            font-size: 10px;
            color: var(--text-light);
            margin-top: 4px;
            text-align: right;
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 12px 16px;
            border-radius: 18px;
            background-color: var(--pastel-blue-light);
            border-bottom-left-radius: 4px;
            max-width: 80px;
            margin-top: 8px;
            align-self: flex-start;
            margin-left: 5px;
            position: relative;
        }

        .typing-indicator::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: -5px;
            width: 10px;
            height: 10px;
            background-color: var(--pastel-blue-light);
            border-bottom-right-radius: 10px;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--text-light);
            animation: typingBounce 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) {
            animation-delay: 0s;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typingBounce {
            0%, 60%, 100% {
                transform: translateY(0);
            }
            30% {
                transform: translateY(-4px);
            }
        }

        .chat-input-container {
            padding: 15px;
            border-top: 1px solid var(--pastel-blue-light);
            display: flex;
            align-items: center;
            gap: 12px;
            background-color: var(--white);
        }

        .chat-input {
            flex: 1;
            background-color: var(--pastel-blue-light);
            border-radius: 24px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .chat-input:focus-within {
            box-shadow: 0 0 0 2px var(--pastel-blue);
        }

        .chat-input input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 14px;
            color: var(--text-dark);
        }

        .chat-input input::placeholder {
            color: var(--text-light);
        }

        .send-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--pastel-green);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            outline: none;
            font-size: 18px;
        }

        .send-button:hover {
            background-color: #8bd0b4;
            transform: scale(1.05);
        }

        .send-button:active {
            transform: scale(0.95);
        }

        .quick-options {
            display: flex;
            gap: 8px;
            padding: 0 15px 15px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .quick-options::-webkit-scrollbar {
            display: none;
        }

        .option-pill {
            background-color: var(--pastel-blue-light);
            padding: 8px 16px;
            border-radius: 16px;
            font-size: 12px;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.2s ease;
            animation: slideIn 0.5s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .option-pill:nth-child(1) {
            animation-delay: 0.1s;
        }

        .option-pill:nth-child(2) {
            animation-delay: 0.2s;
        }

        .option-pill:nth-child(3) {
            animation-delay: 0.3s;
        }

        .option-pill:nth-child(4) {
            animation-delay: 0.4s;
        }

        .option-pill:hover {
            background-color: var(--pastel-blue);
            transform: translateY(-2px);
        }

        .welcome-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--white);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            animation: fadeOut 1s ease 2s forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                visibility: hidden;
            }
        }

        .welcome-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--pastel-green) 0%, var(--pastel-blue) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 40px;
            margin-bottom: 20px;
            animation: pulse 1.5s infinite ease-in-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(168, 230, 207, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(168, 230, 207, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(168, 230, 207, 0);
            }
        }

        .welcome-text {
            font-size: 18px;
            font-weight: bold;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .welcome-subtext {
            font-size: 14px;
            color: var(--text-light);
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <!-- Welcome Animation -->
        <div class="welcome-animation">
            <div class="welcome-icon">💬</div>
            <div class="welcome-text">HealthBuddy</div>
            <div class="welcome-subtext">Your personal health assistant</div>
        </div>

        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-title">HealthBuddy</div>
            <div class="chat-subtitle">Your personal health assistant</div>
        </div>

        <!-- Chat Messages -->
        <div class="chat-messages" id="messages-container">
            <!-- Messages will be added here via JavaScript -->
        </div>

        <!-- Quick Options -->
        <div class="quick-options">
            <div class="option-pill">💪 Exercise tips</div>
            <div class="option-pill">🥗 Healthy eating</div>
            <div class="option-pill">😌 Stress relief</div>
            <div class="option-pill">💤 Sleep better</div>
        </div>

        <!-- Chat Input -->
        <div class="chat-input-container">
            <div class="chat-input">
                <input type="text" placeholder="Type your health question..." id="message-input">
            </div>
            <button class="send-button" id="send-button">➤</button>
        </div>
    </div>

    <script>
        // DOM Elements
        const messagesContainer = document.getElementById('messages-container');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');
        const quickOptions = document.querySelectorAll('.option-pill');

        // Sample responses for health topics
        const botResponses = {
            'exercise': [
                "Regular exercise can boost your mood and energy levels. Try to get at least 150 minutes of moderate activity each week.",
                "For beginners, I recommend starting with walking, swimming, or yoga. What type of exercise interests you?",
                "Remember to warm up before and cool down after exercise to prevent injuries."
            ],
            'diet': [
                "A balanced diet should include plenty of fruits, vegetables, lean proteins, and whole grains.",
                "Staying hydrated is important! Aim to drink at least 8 glasses of water daily.",
                "Try to limit processed foods and added sugars for better overall health."
            ],
            'mental': [
                "Taking just 5 minutes for deep breathing can significantly reduce stress levels.",
                "Mindfulness meditation can help improve focus and reduce anxiety. Have you tried it before?",
                "Remember that it's okay to ask for help when feeling overwhelmed. Mental health is just as important as physical health."
            ],
            'sleep': [
                "Adults should aim for 7-9 hours of quality sleep each night.",
                "Creating a bedtime routine can signal to your body that it's time to wind down.",
                "Try to limit screen time before bed and keep your bedroom cool and dark for better sleep."
            ],
            'default': [
                "I'm here to help with your health questions. Could you tell me more about what you're looking for?",
                "Health is a journey, not a destination. How can I support your wellness goals today?",
                "I can provide information on exercise, nutrition, sleep, and mental wellness. What would you like to know?"
            ]
        };

        // Initial messages after welcome animation
        setTimeout(() => {
            addMessage("Hi there! I'm your HealthBuddy, here to help with your health and wellness questions. How are you feeling today?", 'incoming');
        }, 2500);

        // Event Listeners
        sendButton.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Quick option pills
        quickOptions.forEach(pill => {
            pill.addEventListener('click', function() {
                const text = this.textContent.toLowerCase();
                let messageType = 'default';
                const userMessage = this.textContent.trim();
                
                if (text.includes('exercise')) messageType = 'exercise';
                else if (text.includes('eating') || text.includes('diet')) messageType = 'diet';
                else if (text.includes('stress')) messageType = 'mental';
                else if (text.includes('sleep')) messageType = 'sleep';
                
                addMessage(userMessage, 'outgoing');
                showTypingIndicator();
                
                setTimeout(() => {
                    removeTypingIndicator();
                    // Get random response from appropriate category
                    const responses = botResponses[messageType];
                    const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                    addMessage(randomResponse, 'incoming');
                }, 1500);
            });
        });

        // Send message function
        function sendMessage() {
            const message = messageInput.value.trim();
            if (message === '') return;
            
            addMessage(message, 'outgoing');
            messageInput.value = '';
            
            showTypingIndicator();
            
            // Determine response category
            setTimeout(() => {
                removeTypingIndicator();
                let responseType = 'default';
                const lowerMsg = message.toLowerCase();
                
                if (lowerMsg.includes('exercise') || lowerMsg.includes('workout') || lowerMsg.includes('fitness')) {
                    responseType = 'exercise';
                } else if (lowerMsg.includes('diet') || lowerMsg.includes('food') || lowerMsg.includes('eat') || lowerMsg.includes('nutrition')) {
                    responseType = 'diet';
                } else if (lowerMsg.includes('stress') || lowerMsg.includes('anxiety') || lowerMsg.includes('mental') || lowerMsg.includes('depress')) {
                    responseType = 'mental';
                } else if (lowerMsg.includes('sleep') || lowerMsg.includes('rest') || lowerMsg.includes('tired')) {
                    responseType = 'sleep';
                }
                
                // Get random response from appropriate category
                const responses = botResponses[responseType];
                const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                addMessage(randomResponse, 'incoming');
            }, 1500);
        }

        // Add message to chat
        function addMessage(content, type) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message', type);
            
            const contentDiv = document.createElement('div');
            contentDiv.classList.add('message-content');
            contentDiv.textContent = content;
            
            const timeDiv = document.createElement('div');
            timeDiv.classList.add('message-time');
            timeDiv.textContent = getCurrentTime();
            
            messageDiv.appendChild(contentDiv);
            messageDiv.appendChild(timeDiv);
            messagesContainer.appendChild(messageDiv);
            
            // Scroll to bottom of messages
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Show typing indicator
        function showTypingIndicator() {
            const typingDiv = document.createElement('div');
            typingDiv.classList.add('typing-indicator');
            typingDiv.id = 'typing-indicator';
            
            for (let i = 0; i < 3; i++) {
                const dot = document.createElement('div');
                dot.classList.add('typing-dot');
                typingDiv.appendChild(dot);
            }
            
            messagesContainer.appendChild(typingDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Remove typing indicator
        function removeTypingIndicator() {
            const typingIndicator = document.getElementById('typing-indicator');
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }

        // Get current time for messages
        function getCurrentTime() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            
            hours = hours % 12;
            hours = hours ? hours : 12; // Convert 0 to 12
            
            return `${hours}:${minutes} ${ampm}`;
        }
    </script>
</body>
</html>