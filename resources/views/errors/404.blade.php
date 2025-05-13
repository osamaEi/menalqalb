<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap');
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Cairo', Arial, sans-serif;
        overflow: hidden;
        height: 100vh;
        background: #0a0a0a;
    }

    .error-container {
        position: relative;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #000000 0%, #1a0000 50%, #000000 100%);
    }

    /* Animated background hearts */
    .floating-hearts {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .heart {
        position: absolute;
        color: #C5303A;
        opacity: 0.1;
        animation: floatHeart 15s infinite linear;
    }

    @keyframes floatHeart {
        0% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 0;
        }
        10% {
            opacity: 0.1;
        }
        90% {
            opacity: 0.1;
        }
        100% {
            transform: translateY(-100px) rotate(360deg);
            opacity: 0;
        }
    }

    /* Main content */
    .error-content {
        text-align: center;
        z-index: 10;
        position: relative;
    }

    /* Animated 404 number */
    .error-404 {
        font-size: 15rem;
        font-weight: 900;
        color: #C5303A;
        position: relative;
        line-height: 1;
        margin: 0;
        text-shadow: 0 0 30px rgba(197, 48, 58, 0.5);
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            text-shadow: 0 0 30px rgba(197, 48, 58, 0.5);
        }
        50% {
            transform: scale(1.05);
            text-shadow: 0 0 50px rgba(197, 48, 58, 0.8);
        }
    }

    /* Envelope animation */
    .envelope-container {
        position: relative;
        width: 200px;
        height: 150px;
        margin: -50px auto 30px;
    }

    .envelope {
        width: 200px;
        height: 150px;
        position: relative;
        animation: wobble 3s ease-in-out infinite;
    }

    @keyframes wobble {
        0%, 100% { transform: rotate(-5deg); }
        50% { transform: rotate(5deg); }
    }

    .envelope-body {
        position: absolute;
        width: 100%;
        height: 100%;
        background: #C5303A;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .envelope-top {
        position: absolute;
        width: 0;
        height: 0;
        border-left: 100px solid transparent;
        border-right: 100px solid transparent;
        border-top: 80px solid #A52834;
        top: 0;
        z-index: 2;
    }

    .heart-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 60px;
        color: white;
        z-index: 3;
        animation: heartBeat 1.5s ease-in-out infinite;
    }

    @keyframes heartBeat {
        0%, 100% { transform: translate(-50%, -50%) scale(1); }
        50% { transform: translate(-50%, -50%) scale(1.1); }
    }

    /* Error text */
    .error-text {
        color: #C5303A;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 20px 0;
        direction: rtl;
        animation: fadeIn 1s ease-in;
    }

    .error-subtext {
        color: #888;
        font-size: 1.2rem;
        margin: 10px 0 40px;
        direction: rtl;
        animation: fadeIn 1.5s ease-in;
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

    /* Button */
    .home-button {
        display: inline-block;
        padding: 15px 50px;
        background: transparent;
        color: #C5303A;
        text-decoration: none;
        border: 3px solid #C5303A;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        direction: rtl;
    }

    .home-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: #C5303A;
        transition: all 0.3s ease;
        z-index: -1;
    }

    .home-button:hover {
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(197, 48, 58, 0.3);
    }

    .home-button:hover::before {
        left: 0;
    }

    /* Animated envelope letters */
    .love-letters {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .letter {
        position: absolute;
        width: 40px;
        height: 30px;
        background: white;
        border: 2px solid #C5303A;
        opacity: 0;
        animation: sendLetter 8s infinite;
    }

    .letter::after {
        content: '♥';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #C5303A;
        font-size: 16px;
    }

    @keyframes sendLetter {
        0% {
            opacity: 0;
            transform: translate(0, 0) scale(0);
        }
        10% {
            opacity: 1;
            transform: translate(0, 0) scale(1);
        }
        90% {
            opacity: 1;
            transform: translate(300px, -300px) scale(0.8) rotate(360deg);
        }
        100% {
            opacity: 0;
            transform: translate(350px, -350px) scale(0.5) rotate(720deg);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .error-404 {
            font-size: 8rem;
        }
        .error-text {
            font-size: 1.8rem;
        }
        .error-subtext {
            font-size: 1rem;
        }
        .envelope-container {
            transform: scale(0.8);
        }
    }
</style>

<div class="error-container">
    <!-- Floating hearts background -->
    <div class="floating-hearts" id="floatingHearts"></div>
    
    <!-- Flying letters animation -->
    <div class="love-letters" id="loveLetters"></div>

    <!-- Main content -->
    <div class="error-content">
        <h1 class="error-404">404</h1>
        
        <!-- Animated envelope -->
        <div class="envelope-container">
            <div class="envelope">
                <div class="envelope-body"></div>
                <div class="envelope-top"></div>
                <div class="heart-icon">♥</div>
            </div>
        </div>
        
        <p class="error-text">عذراً! رسالتك ضلت الطريق</p>
        <p class="error-subtext">يبدو أن الصفحة التي تبحث عنها قد اختفت في بريد الحب</p>
        
        <a href="{{ route('welcome') }}" class="home-button">
            العودة للرئيسية ♥
        </a>
    </div>
</div>

<script>
    // Create floating hearts
    const heartsContainer = document.getElementById('floatingHearts');
    const heartSymbols = ['♥', '♡', '💕', '💖', '💗', '💝'];
    
    for (let i = 0; i < 20; i++) {
        const heart = document.createElement('div');
        heart.className = 'heart';
        heart.innerHTML = heartSymbols[Math.floor(Math.random() * heartSymbols.length)];
        heart.style.left = Math.random() * 100 + '%';
        heart.style.fontSize = (Math.random() * 30 + 20) + 'px';
        heart.style.animationDelay = Math.random() * 15 + 's';
        heart.style.animationDuration = (Math.random() * 10 + 15) + 's';
        heartsContainer.appendChild(heart);
    }

    // Create flying letters
    const lettersContainer = document.getElementById('loveLetters');
    setInterval(() => {
        const letter = document.createElement('div');
        letter.className = 'letter';
        letter.style.left = '50%';
        letter.style.top = '50%';
        letter.style.animationDelay = '0s';
        letter.style.animationDuration = (Math.random() * 3 + 5) + 's';
        lettersContainer.appendChild(letter);
        
        // Clean up old letters
        setTimeout(() => {
            letter.remove();
        }, 8000);
    }, 2000);

    // Mouse interaction effect
    document.addEventListener('mousemove', (e) => {
        const x = e.clientX / window.innerWidth;
        const y = e.clientY / window.innerHeight;
        
        const hearts = document.querySelectorAll('.heart');
        hearts.forEach((heart, index) => {
            const speed = (index + 1) * 0.01;
            heart.style.transform = `translate(${x * speed * 50}px, ${y * speed * 50}px)`;
        });
    });

    // Click to create heart burst
    document.addEventListener('click', (e) => {
        for (let i = 0; i < 5; i++) {
            const heart = document.createElement('div');
            heart.innerHTML = '♥';
            heart.style.position = 'fixed';
            heart.style.left = e.clientX + 'px';
            heart.style.top = e.clientY + 'px';
            heart.style.color = '#C5303A';
            heart.style.fontSize = '20px';
            heart.style.pointerEvents = 'none';
            heart.style.animation = `heartBurst 1s ease-out forwards`;
            heart.style.transform = `rotate(${Math.random() * 360}deg)`;
            
            document.body.appendChild(heart);
            
            setTimeout(() => {
                heart.remove();
            }, 1000);
        }
    });

    // Add heart burst animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes heartBurst {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translate(${Math.random() * 200 - 100}px, ${Math.random() * 200 - 100}px) scale(0);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>