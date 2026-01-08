<?php
/**
 * Template Name: Smart Systems Landing Page (Standalone)
 * Description: Immersive 3D landing page - completely standalone, no theme interference
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Remove all actions that might add theme elements
remove_all_actions('wp_head');
remove_all_actions('wp_footer');
remove_all_actions('wp_print_styles');
remove_all_actions('wp_print_head_scripts');

// Disable admin bar
show_admin_bar(false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Systems Implementation - BackOffice Systems</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background: #fff;
            color: #1B365D;
            overflow: hidden;
        }

        #canvas-container {
            width: 100vw;
            height: 100vh;
            position: relative;
        }

        .ui-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 100;
        }

        .top-bar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            padding: 16px 40px;
            border-bottom: 3px solid #C1403D;
            backdrop-filter: blur(10px);
            pointer-events: all;
            z-index: 101;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo {
            height: 50px;
            width: auto;
        }

        .brand-name {
            font-size: 20px;
            font-weight: 600;
            color: #1B365D;
            letter-spacing: 0.5px;
        }

        .content-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 900px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto;
            text-align: center;
            pointer-events: none;
            transition: opacity 0.5s ease;
            z-index: 200;
        }

        .content-overlay::-webkit-scrollbar {
            width: 8px;
        }

        .content-overlay::-webkit-scrollbar-track {
            background: rgba(27, 54, 93, 0.1);
            border-radius: 4px;
        }

        .content-overlay::-webkit-scrollbar-thumb {
            background: rgba(193, 64, 61, 0.5);
            border-radius: 4px;
        }

        .content-overlay::-webkit-scrollbar-thumb:hover {
            background: rgba(193, 64, 61, 0.7);
        }

        .content-overlay h1 {
            color: #1B365D;
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(255,255,255,0.8);
        }

        .content-overlay .subhead {
            color: #1B365D;
            font-size: 20px;
            font-weight: 300;
            line-height: 1.6;
            opacity: 0.9;
            text-shadow: 0 2px 10px rgba(255,255,255,0.8);
        }

        .service-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 40px;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 32px 24px;
            border-radius: 8px;
            border: 2px solid rgba(27, 54, 93, 0.1);
            transition: all 0.3s ease;
            pointer-events: all;
            text-align: left;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(27, 54, 93, 0.15);
            border-color: #C1403D;
        }

        .service-card h3 {
            color: #1B365D;
            font-size: 22px;
            margin-bottom: 12px;
        }

        .service-card .price {
            color: #1B365D;
            font-size: 28px;
            font-weight: 700;
            margin: 12px 0 4px;
        }

        .service-card .duration {
            color: #1B365D;
            opacity: 0.7;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .service-card p {
            color: #1B365D;
            opacity: 0.85;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .service-card ul {
            list-style: none;
            padding: 0;
        }

        .service-card ul li {
            color: #1B365D;
            opacity: 0.8;
            padding: 8px 0;
            padding-left: 24px;
            position: relative;
            font-size: 14px;
        }

        .service-card ul li:before {
            content: "→";
            position: absolute;
            left: 0;
            color: #C1403D;
            font-weight: bold;
        }

        .qualifier-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 40px;
        }

        .qualifier-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 32px 24px;
            border-radius: 8px;
            border-left: 4px solid #1B365D;
            pointer-events: all;
            text-align: left;
        }

        .qualifier-card h4 {
            color: #1B365D;
            font-size: 18px;
            margin-bottom: 16px;
            font-weight: 600;
        }

        .qualifier-card ul {
            list-style: none;
            padding: 0;
        }

        .qualifier-card ul li {
            color: #1B365D;
            opacity: 0.85;
            padding: 10px 0;
            padding-left: 24px;
            position: relative;
            line-height: 1.5;
        }

        .qualifier-card ul li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #C1403D;
            font-weight: bold;
            font-size: 20px;
        }

        .process-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-top: 40px;
        }

        .process-step {
            background: rgba(255, 255, 255, 0.95);
            padding: 32px 24px;
            border-radius: 8px;
            border: 2px solid rgba(27, 54, 93, 0.1);
            pointer-events: all;
            text-align: left;
            position: relative;
        }

        .process-step .number {
            position: absolute;
            top: -20px;
            left: 24px;
            background: #C1403D;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
        }

        .process-step h4 {
            color: #1B365D;
            font-size: 18px;
            margin-bottom: 12px;
            margin-top: 8px;
        }

        .process-step p {
            color: #1B365D;
            opacity: 0.85;
            line-height: 1.6;
        }

        .contact-form {
            max-width: 500px;
            margin: 24px auto 0;
            text-align: left;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #1B365D;
            font-size: 13px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid rgba(27, 54, 93, 0.2);
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            color: #1B365D;
            pointer-events: all;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #C1403D;
        }

        .form-group textarea {
            min-height: 70px;
            resize: vertical;
        }

        .submit-button {
            background: #C1403D;
            color: white;
            padding: 14px 40px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            pointer-events: all;
        }

        .submit-button:hover {
            background: #a03532;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(193, 64, 61, 0.3);
        }

        .submit-button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .form-message {
            margin-top: 16px;
            padding: 12px;
            border-radius: 4px;
            font-size: 14px;
            display: none;
        }

        .form-message.success {
            background: rgba(76, 175, 80, 0.1);
            color: #2e7d32;
            border: 1px solid rgba(76, 175, 80, 0.3);
        }

        .form-message.error {
            background: rgba(244, 67, 54, 0.1);
            color: #c62828;
            border: 1px solid rgba(244, 67, 54, 0.3);
        }

        .nav-dots {
            position: fixed;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: all;
            z-index: 102;
        }

        .nav-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(193, 64, 61, 0.5);
            margin: 16px 0;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #1B365D;
            position: relative;
        }

        .nav-dot:hover {
            background: rgba(193, 64, 61, 0.8);
            transform: scale(1.2);
            border-color: #C1403D;
        }

        .nav-dot.active {
            background: #C1403D;
            border-color: #1B365D;
            box-shadow: 0 0 20px rgba(193, 64, 61, 0.8);
        }

        .nav-label {
            position: absolute;
            right: 25px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(27, 54, 93, 0.95);
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            border: 1px solid #C1403D;
        }

        .nav-dot:hover .nav-label {
            opacity: 1;
        }

        .controls-hint {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(27, 54, 93, 0.9);
            color: white;
            padding: 12px 24px;
            border-radius: 20px;
            font-size: 12px;
            pointer-events: none;
            z-index: 101;
        }
    </style>
</head>
<body>

    <div id="canvas-container"></div>

    <div class="ui-overlay">
        <div class="top-bar">
            <div class="brand">
                <img src="https://lightslategrey-chamois-591019.hostingersite.com/wp-content/uploads/2026/01/ll.jpg" alt="BackOffice Systems" class="logo">
                <span class="brand-name">BACKOFFICE SYSTEMS</span>
            </div>
        </div>

        <div class="nav-dots">
            <div class="nav-dot active" data-section="0">
                <div class="nav-label">Home</div>
            </div>
            <div class="nav-dot" data-section="1">
                <div class="nav-label">Services</div>
            </div>
            <div class="nav-dot" data-section="2">
                <div class="nav-label">Who This Is For</div>
            </div>
            <div class="nav-dot" data-section="3">
                <div class="nav-label">Process</div>
            </div>
            <div class="nav-dot" data-section="4">
                <div class="nav-label">Contact</div>
            </div>
        </div>

        <!-- Section 0: Hero -->
        <div class="content-overlay" id="section-0" style="opacity: 1;">
            <h1 style="color: #1B365D; text-shadow: 0 2px 10px rgba(255,255,255,0.9), 0 0 40px rgba(255,255,255,0.5);">Smart Systems Implementation</h1>
            <p class="subhead" style="color: #1B365D; text-shadow: 0 2px 10px rgba(255,255,255,0.9), 0 0 30px rgba(255,255,255,0.5);">We build your systems, automate them, then add intelligence and visibility so they improve over time.</p>
        </div>

        <!-- Section 1: Services -->
        <div class="content-overlay" id="section-1" style="opacity: 0;">
            <h1 style="font-size: 42px; margin-bottom: 16px;">How It Works</h1>
            <div class="service-cards">
                <div class="service-card">
                    <h3>Build the System</h3>
                    <div class="price">Phase 1</div>
                    <div class="duration">Foundation</div>
                    <p>We design and implement your core operational systems with proper integration and data structure. Already using Monday, Airtable, or other tools? We work with what you have and enhance it.</p>
                    <ul>
                        <li>Workflow analysis and system design</li>
                        <li>Integration across existing tools</li>
                        <li>Structured data capture</li>
                        <li>Process documentation</li>
                    </ul>
                </div>
                <div class="service-card">
                    <h3>Automate the System</h3>
                    <div class="price">Phase 2</div>
                    <div class="duration">Implementation</div>
                    <p>Once core systems are in place, we configure them to support ongoing visibility and adaptive improvement.</p>
                    <ul>
                        <li>Event tracking across workflows</li>
                        <li>Automation logic that responds to usage</li>
                        <li>Manager-facing dashboards for oversight</li>
                        <li>Real-time process monitoring</li>
                    </ul>
                </div>
                <div class="service-card">
                    <h3>Smart Systems Subscription</h3>
                    <div class="price">Monthly</div>
                    <div class="duration">Living Infrastructure</div>
                    <p>Automated oversight, adaptive recommendations, and continuous system refinement. Your team monitors and adjusts systems instead of doing manual work.</p>
                    <ul>
                        <li>Automated agent monitoring workflows</li>
                        <li>Visual interface for real-time observation</li>
                        <li>Pattern detection and operational insights</li>
                        <li>Team training on system oversight</li>
                        <li>Suggested optimizations based on behavior</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section 2: Who This Is For -->
        <div class="content-overlay" id="section-2" style="opacity: 0;">
            <h1 style="font-size: 42px; margin-bottom: 16px;">Who This Is For</h1>
            <div class="qualifier-section">
                <div class="qualifier-card">
                    <h4>Good Fit</h4>
                    <ul>
                        <li>Established teams (5+ people) with recurring workflows</li>
                        <li>Operations involving handoffs, approvals, or dependencies</li>
                        <li>Multiple systems that need to work together</li>
                        <li>Already using tools like Monday, Airtable, or similar (we enhance what you have)</li>
                        <li>Leaders who want visibility without manual reporting</li>
                        <li>Organizations open to automation + intelligent oversight</li>
                    </ul>
                </div>
                <div class="qualifier-card">
                    <h4>Better Fit for One-Time Engagement</h4>
                    <ul>
                        <li>Teams seeking a specific system or automation build</li>
                        <li>Clear requirements and defined workflows</li>
                        <li>Internal teams that will manage systems after handoff</li>
                        <li>Prefer project-based over subscription model</li>
                    </ul>
                </div>
            </div>
            <div class="qualifier-card" style="margin-top: 30px; max-width: 700px; margin-left: auto; margin-right: auto;">
                <h4>Not a Fit</h4>
                <ul>
                    <li>Looking for generic tools or templates</li>
                    <li>Expecting automation without process ownership</li>
                    <li>No capacity to act on insights or recommendations</li>
                    <li>Primarily cost-driven, not outcome-driven</li>
                </ul>
            </div>
        </div>

        <!-- Section 3: Process -->
        <div class="content-overlay" id="section-3" style="opacity: 0;">
            <h1 style="font-size: 42px; margin-bottom: 16px;">Your Journey to Smart Systems</h1>
            <div class="process-steps">
                <div class="process-step">
                    <div class="number">01</div>
                    <h4>Discovery & Design</h4>
                    <p>We map your workflows and design your automated agents + visual dashboard</p>
                </div>
                <div class="process-step">
                    <div class="number">02</div>
                    <h4>Build & Deploy</h4>
                    <p>We integrate systems, build agents, and launch your interactive management dashboard</p>
                </div>
                <div class="process-step">
                    <div class="number">03</div>
                    <h4>Ongoing Optimization</h4>
                    <p>Your subscription includes 24/7 automation + AI-powered improvement suggestions</p>
                </div>
            </div>
            <div class="qualifier-card" style="margin-top: 30px; max-width: 700px; margin-left: auto; margin-right: auto;">
                <h4>Subscription Model — What's Included</h4>
                <ul>
                    <li>Automated agent monitoring workflows and system events</li>
                    <li>Visual interface for managers to observe processes in real time</li>
                    <li>Pattern detection and operational insights</li>
                    <li>Suggested optimizations based on actual system behavior</li>
                    <li>Ongoing system tuning and automation adjustments</li>
                </ul>
                <p style="margin-top: 16px; font-size: 13px; color: #666; font-style: italic;">Designed for operations managers overseeing complex processes. Asynchronous support with optional quarterly reviews. Pricing based on system complexity and data volume.</p>
            </div>
            
            <div class="qualifier-card" style="margin-top: 30px; max-width: 700px; margin-left: auto; margin-right: auto; background: rgba(193, 64, 61, 0.05); border-left-color: #C1403D;">
                <h4 style="color: #C1403D;">What Happens to Your Team?</h4>
                <p style="font-size: 14px; line-height: 1.7; color: #1B365D; margin-bottom: 12px;">
                    We don't replace people — we upgrade them. When automation handles routine tasks, your employees are trained to monitor and optimize the systems. They work fewer hours at a higher rate, making them more valuable while reducing your costs.
                </p>
                <p style="font-size: 13px; color: #666; margin-top: 8px;">
                    <strong>Example:</strong> A 40-hour/week employee at $25/hour ($1,000/week) becomes a 20-hour/week system manager at $35/hour ($700/week). Same person, higher skills, 30% cost savings.
                </p>
            </div>
        </div>

        <!-- Section 4: Contact -->
        <div class="content-overlay" id="section-4" style="opacity: 0;">
            <h1 style="font-size: 42px; margin-bottom: 16px;">Request Introduction</h1>
            <form class="contact-form" id="contactForm">
                <div class="form-group">
                    <label for="company">Company Name</label>
                    <input type="text" id="company" name="company" required>
                </div>
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="engagement">Preferred Engagement</label>
                    <select id="engagement" name="engagement" required>
                        <option value="">Select an option</option>
                        <option value="assessment">Systems Assessment</option>
                        <option value="full-implementation">Full Implementation</option>
                        <option value="subscription">Smart Systems Subscription</option>
                        <option value="consultation">Initial Consultation</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Tell us about your operations</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit" class="submit-button">Send Inquiry</button>
                <div class="form-message" id="formMessage"></div>
            </form>
        </div>

        <div class="controls-hint">
            Scroll to navigate • Click & drag to explore
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        let scene, camera, renderer, controls;
        let particles = [];
        let shapes = [];
        let neuralNetwork;
        let currentSection = 0;
        let isTransitioning = false;
        let scrollTimeout = null;
        let pathway = [];
        let rewardIcons = [];
        let progressParticles = [];

        function init() {
            scene = new THREE.Scene();
            scene.background = new THREE.Color(0xffffff);
            scene.fog = new THREE.Fog(0xffffff, 20, 100);

            camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.z = 30;

            renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            document.getElementById('canvas-container').appendChild(renderer.domElement);

            const OrbitControls = THREE.OrbitControls;
            controls = new OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;
            controls.dampingFactor = 0.05;
            controls.enableZoom = true;
            controls.enablePan = true;
            controls.autoRotate = false;
            controls.autoRotateSpeed = 0;

            createEnvironment();
            createPathway();
            createRewardIcons();
            createLights();

            window.addEventListener('resize', onWindowResize);
            window.addEventListener('wheel', onScroll, { passive: false });
            
            document.querySelectorAll('.nav-dot').forEach(dot => {
                dot.addEventListener('click', function() {
                    const section = parseInt(this.getAttribute('data-section'));
                    navigateToSection(section);
                });
            });

            animate();
        }

        function createEnvironment() {
            const particleCount = 200;
            const particleGeometry = new THREE.BufferGeometry();
            const particlePositions = new Float32Array(particleCount * 3);

            for (let i = 0; i < particleCount; i++) {
                particlePositions[i * 3] = (Math.random() - 0.5) * 100;
                particlePositions[i * 3 + 1] = (Math.random() - 0.5) * 100;
                particlePositions[i * 3 + 2] = (Math.random() - 0.5) * 100;
            }

            particleGeometry.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
            const particleMaterial = new THREE.PointsMaterial({
                color: 0xC1403D,
                size: 0.5,
                transparent: true,
                opacity: 0.6
            });

            const particleSystem = new THREE.Points(particleGeometry, particleMaterial);
            scene.add(particleSystem);
            particles.push({ system: particleSystem, velocities: [] });

            for (let i = 0; i < particleCount; i++) {
                particles[0].velocities.push({
                    x: (Math.random() - 0.5) * 0.02,
                    y: (Math.random() - 0.5) * 0.02,
                    z: (Math.random() - 0.5) * 0.02
                });
            }

            const geometries = [
                new THREE.BoxGeometry(2, 2, 2),
                new THREE.SphereGeometry(1, 16, 16),
                new THREE.ConeGeometry(1, 2, 16)
            ];

            for (let i = 0; i < 15; i++) {
                const geometry = geometries[Math.floor(Math.random() * geometries.length)];
                const material = new THREE.MeshPhongMaterial({
                    color: Math.random() > 0.5 ? 0x1B365D : 0xC1403D,
                    transparent: true,
                    opacity: 0.3,
                    wireframe: true
                });
                const mesh = new THREE.Mesh(geometry, material);
                mesh.position.set(
                    (Math.random() - 0.5) * 60,
                    (Math.random() - 0.5) * 60,
                    (Math.random() - 0.5) * 60
                );
                mesh.userData.rotationSpeed = {
                    x: (Math.random() - 0.5) * 0.01,
                    y: (Math.random() - 0.5) * 0.01,
                    z: (Math.random() - 0.5) * 0.01
                };
                scene.add(mesh);
                shapes.push(mesh);
            }

            const tubeCount = 30;
            const tubeGeometry = new THREE.BufferGeometry();
            const tubePositions = new Float32Array(tubeCount * 6);

            for (let i = 0; i < tubeCount; i++) {
                const startX = (Math.random() - 0.5) * 80;
                const startY = (Math.random() - 0.5) * 80;
                const startZ = (Math.random() - 0.5) * 80;
                const endX = startX + (Math.random() - 0.5) * 20;
                const endY = startY + (Math.random() - 0.5) * 20;
                const endZ = startZ + (Math.random() - 0.5) * 20;

                tubePositions[i * 6] = startX;
                tubePositions[i * 6 + 1] = startY;
                tubePositions[i * 6 + 2] = startZ;
                tubePositions[i * 6 + 3] = endX;
                tubePositions[i * 6 + 4] = endY;
                tubePositions[i * 6 + 5] = endZ;
            }

            tubeGeometry.setAttribute('position', new THREE.BufferAttribute(tubePositions, 3));
            const tubeMaterial = new THREE.LineBasicMaterial({
                color: 0x1B365D,
                transparent: true,
                opacity: 0.2
            });
            neuralNetwork = new THREE.LineSegments(tubeGeometry, tubeMaterial);
            scene.add(neuralNetwork);
        }

        function createPathway() {
            for (let i = 0; i < 5; i++) {
                const z = -i * 10;
                
                const ringGeometry = new THREE.TorusGeometry(8, 0.3, 16, 100);
                const ringMaterial = new THREE.MeshBasicMaterial({
                    color: 0xC1403D,
                    transparent: true,
                    opacity: 0,
                    emissive: 0xC1403D,
                    emissiveIntensity: 0
                });
                const ring = new THREE.Mesh(ringGeometry, ringMaterial);
                ring.position.z = z;
                ring.userData.targetOpacity = 0.3;
                ring.userData.section = i;
                scene.add(ring);
                pathway.push(ring);

                if (i < 4) {
                    const lineGeometry = new THREE.BufferGeometry();
                    const linePositions = new Float32Array(200 * 3);
                    for (let j = 0; j < 200; j++) {
                        const angle = (j / 200) * Math.PI * 2;
                        const radius = 8;
                        linePositions[j * 3] = Math.cos(angle) * radius;
                        linePositions[j * 3 + 1] = Math.sin(angle) * radius;
                        linePositions[j * 3 + 2] = z + (j / 200) * -10;
                    }
                    lineGeometry.setAttribute('position', new THREE.BufferAttribute(linePositions, 3));
                    const lineMaterial = new THREE.LineBasicMaterial({
                        color: 0xC1403D,
                        transparent: true,
                        opacity: 0
                    });
                    const lines = new THREE.Line(lineGeometry, lineMaterial);
                    lines.userData.targetOpacity = 0.15;
                    lines.userData.section = i;
                    scene.add(lines);
                    pathway.push(lines);
                }
            }
        }

        function createRewardIcons() {
            const rewards = [
                { icon: '⏱️', label: 'Time Saved', z: -10, color: 0x1B365D },
                { icon: '💰', label: 'Cost Reduced', z: -20, color: 0xFFD700 },
                { icon: '⚡', label: 'Efficiency', z: -30, color: 0xC1403D },
                { icon: '✨', label: 'Automation', z: -40, color: 0x1B365D }
            ];

            rewards.forEach((reward, index) => {
                const geometry = new THREE.SphereGeometry(2, 32, 32);
                const material = new THREE.MeshBasicMaterial({
                    color: reward.color,
                    transparent: true,
                    opacity: 0,
                    emissive: reward.color,
                    emissiveIntensity: 0
                });
                const sphere = new THREE.Mesh(geometry, material);
                sphere.position.set(10, 3, reward.z);
                sphere.userData.targetOpacity = 0.6;
                sphere.userData.targetEmissive = 0.7;
                sphere.userData.section = index + 1;
                sphere.userData.baseY = 0;
                scene.add(sphere);
                rewardIcons.push(sphere);

                const particleCount = 30;
                const particleGeometry = new THREE.BufferGeometry();
                const particlePositions = new Float32Array(particleCount * 3);
                
                for (let i = 0; i < particleCount; i++) {
                    const angle = (i / particleCount) * Math.PI * 2;
                    particlePositions[i * 3] = 10 + Math.cos(angle) * 3;
                    particlePositions[i * 3 + 1] = 3 + Math.sin(angle) * 3;
                    particlePositions[i * 3 + 2] = reward.z;
                }
                
                particleGeometry.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
                const particleMaterial = new THREE.PointsMaterial({
                    color: reward.color,
                    size: 0.2,
                    transparent: true,
                    opacity: 0
                });
                const particleRing = new THREE.Points(particleGeometry, particleMaterial);
                particleRing.userData.targetOpacity = 0.8;
                particleRing.userData.section = index + 1;
                scene.add(particleRing);
                progressParticles.push(particleRing);
            });
        }

        function createLights() {
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
            scene.add(ambientLight);

            const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
            directionalLight.position.set(10, 10, 10);
            scene.add(directionalLight);

            const pointLight = new THREE.PointLight(0xC1403D, 1, 100);
            pointLight.position.set(0, 0, 20);
            scene.add(pointLight);
        }

        function navigateToSection(index) {
            if (isTransitioning || index === currentSection) return;
            
            isTransitioning = true;
            currentSection = index;

            document.querySelectorAll('.content-overlay').forEach((el, i) => {
                if (i === index) {
                    el.style.opacity = '1';
                    el.style.pointerEvents = 'auto';
                } else {
                    el.style.opacity = '0';
                    el.style.pointerEvents = 'none';
                }
            });

            setTimeout(() => {
                isTransitioning = false;
            }, 500);

            document.querySelectorAll('.nav-dot').forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });

            activatePathwayToSection(index);

            const targetZ = 30;
            animateCamera(targetZ);
        }

        function activatePathwayToSection(targetSection) {
            pathway.forEach(element => {
                if (element.userData.section <= targetSection) {
                    element.material.opacity = element.userData.targetOpacity;
                    if (element.material.emissiveIntensity !== undefined) {
                        element.material.emissiveIntensity = 0.5;
                    }
                }
            });

            rewardIcons.forEach(icon => {
                if (icon.userData.section <= targetSection) {
                    icon.material.opacity = icon.userData.targetOpacity;
                    icon.material.emissiveIntensity = icon.userData.targetEmissive;
                }
            });

            progressParticles.forEach(particle => {
                if (particle.userData.section <= targetSection) {
                    particle.material.opacity = particle.userData.targetOpacity;
                }
            });
        }

        function animateCamera(targetZ) {
            const startZ = camera.position.z;
            const duration = 1000;
            const startTime = Date.now();

            function updateCamera() {
                const elapsed = Date.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                
                camera.position.z = startZ + (targetZ - startZ) * eased;

                if (progress < 1) {
                    requestAnimationFrame(updateCamera);
                }
            }

            updateCamera();
        }

        function onScroll(event) {
            event.preventDefault();
            if (isTransitioning || scrollTimeout) return;

            scrollTimeout = setTimeout(() => {
                scrollTimeout = null;
            }, 800);

            const delta = event.deltaY;
            
            if (delta > 0 && currentSection < 4) {
                navigateToSection(currentSection + 1);
            } else if (delta < 0 && currentSection > 0) {
                navigateToSection(currentSection - 1);
            }
        }

        function onWindowResize() {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        }

        function animate() {
            requestAnimationFrame(animate);

            particles.forEach(particleGroup => {
                const positions = particleGroup.system.geometry.attributes.position.array;
                particleGroup.velocities.forEach((vel, i) => {
                    positions[i * 3] += vel.x * 0.5;
                    positions[i * 3 + 1] += vel.y * 0.5;
                    positions[i * 3 + 2] += vel.z * 0.5;

                    if (Math.abs(positions[i * 3]) > 50) vel.x *= -1;
                    if (Math.abs(positions[i * 3 + 1]) > 50) vel.y *= -1;
                    if (Math.abs(positions[i * 3 + 2]) > 50) vel.z *= -1;
                });
                particleGroup.system.geometry.attributes.position.needsUpdate = true;
            });

            shapes.forEach(shape => {
                shape.rotation.x += shape.userData.rotationSpeed.x * 0.3;
                shape.rotation.y += shape.userData.rotationSpeed.y * 0.3;
                shape.rotation.z += shape.userData.rotationSpeed.z * 0.3;
            });

            if (neuralNetwork) {
                neuralNetwork.rotation.y += 0.0003;
                const positions = neuralNetwork.geometry.attributes.position.array;
                for (let i = 0; i < positions.length; i += 6) {
                    const index = i / 6;
                    positions[i + 1] += Math.sin(Date.now() * 0.0005 + index) * 0.1;
                    positions[i + 4] += Math.cos(Date.now() * 0.0005 + index) * 0.1;
                }
                neuralNetwork.geometry.attributes.position.needsUpdate = true;
            }

            pathway.forEach((element, index) => {
                if (element.material.emissiveIntensity > 0) {
                    element.material.emissiveIntensity = 0.5 + Math.sin(Date.now() * 0.001 + index) * 0.2;
                }
            });

            rewardIcons.forEach((icon, index) => {
                if (icon.material.opacity > 0) {
                    icon.position.y = icon.userData.baseY + Math.sin(Date.now() * 0.001 + index) * 0.5;
                    icon.material.emissiveIntensity = icon.userData.targetEmissive + Math.sin(Date.now() * 0.002 + index) * 0.3;
                }
            });

            progressParticles.forEach((particle, index) => {
                if (particle.material.opacity > 0) {
                    particle.rotation.z += 0.01;
                }
            });

            controls.update();
            renderer.render(scene, camera);
        }

        document.getElementById('contactForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('.submit-button');
            const formMessage = document.getElementById('formMessage');
            
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';
            
            const formData = {
                company: document.getElementById('company').value,
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                engagement: document.getElementById('engagement').value,
                message: document.getElementById('message').value
            };

            try {
                const response = await fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'smart_systems_contact',
                        ...formData
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    formMessage.textContent = 'Thank you! We\'ll be in touch soon.';
                    formMessage.className = 'form-message success';
                    formMessage.style.display = 'block';
                    this.reset();
                } else {
                    throw new Error(result.data || 'Submission failed');
                }
            } catch (error) {
                formMessage.textContent = 'There was an error. Please email us directly at info@manageonsite.com';
                formMessage.className = 'form-message error';
                formMessage.style.display = 'block';
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Send Inquiry';
            }
        });

        init();
    </script>

</body>
</html>
