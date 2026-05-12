    <!-- Load Inter and Lora Fonts for Readability -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* --- CSS Variables for Theming --- */
        :root {
            /* Light Theme Defaults */
            --bg-body: #f0f4f8; 	/* Light blue-gray background */
            --bg-neumorphic: #f0f4f8; /* Same as body for flush effect */
            --text-primary: #1e293b; 	/* Dark slate for body text */
            --text-heading: #0f172a; 	/* Very dark slate for headings */
            --shadow-dark: #d1d9e6; 	/* Dark part of neumorphic shadow */
            --shadow-light: #ffffff; 	/* Light part of neumorphic shadow */
            --bg-input: #eef2f6; 	/* Slightly darker input background */
            --border-color: rgba(0, 0, 0, 0.05);
            --article-bg-hover: #e5e7eb; /* gray-200 */
        }

        .dark-mode {
            /* Dark Theme Overrides */
            --bg-body: #0f172a; 	/* Dark slate background */
            --bg-neumorphic: #1e293b; /* Darker slate for cards */
            --text-primary: #e2e8f0; 	/* Light slate for body text */
            --text-heading: #f8fafc; 	/* White for headings */
            --shadow-dark: #0d121d; 	/* Darker, bottom-right shadow */
            --shadow-light: #2f3e57; 	/* Lighter, top-left shadow */
            --bg-input: #1a2434; 	/* Darker input background */
            --border-color: rgba(255, 255, 255, 0.05);
            --article-bg-hover: #334155; /* slate-700 */
        }

        /* Custom gradient for the navigation bar (kept bright for visual interest) */
        .nav-gradient {
            background: linear-gradient(to right, #1D4ED8, #3B82F6); /* Blue shades */
        }
        
        /* Custom scrollbar styling for potentially overflowing nav on very narrow screens */
        .nav-scrollable::-webkit-scrollbar {
            display: none; /* Hide scrollbar for Chrome, Safari and Opera */
        }
        .nav-scrollable {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
        
        /* --- Dynamic Base Styles --- */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body); 
            color: var(--text-primary);
            transition: background-color 0.3s, color 0.3s;
        }

        h1, h2, h3, h4 {
            font-family: 'Lora', serif;
            color: var(--text-heading);
        }
        
        /* Dynamic Neumorphism (Skeuomorphism) effect for the cards */
        .neumorphic {
            background-color: var(--bg-neumorphic);
            /* Dynamic shadows based on CSS variables */
            box-shadow: 
                8px 8px 16px var(--shadow-dark), 
                -8px -8px 16px var(--shadow-light); 
            border: 1px solid var(--border-color);
            transition: background-color 0.3s, box-shadow 0.3s, border-color 0.3s;
        }

        /* Scrolling logo animation */
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-scroll {
            display: flex;
            animation: scroll 20s linear infinite;
            width: max-content;
        }
        
        /* Smooth transition for the content reveal (Archive tab) */
        .collapse-content {
            transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out;
            overflow: hidden;
        }
        
        .collapse-content:not(.active) {
            max-height: 0;
            opacity: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        
        .collapse-content.active {
            max-height: 2000px; /* Large value to accommodate content */
            opacity: 1;
        }

        .article-link {
            transition: color 0.3s, text-decoration-color 0.3s;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }
        
        /* Dynamic Neumorphic Input Fields */
        .neumorphic-input {
            background-color: var(--bg-input); 
            border-radius: 8px;
            color: var(--text-heading); 
            /* Inset shadow for a "pressed" look */
            box-shadow: inset 3px 3px 6px var(--shadow-dark), inset -3px -3px 6px var(--shadow-light);
            transition: all 0.2s ease-in-out;
            border: 1px solid transparent;
        }

        .neumorphic-input:focus {
            outline: none;
            /* Focus ring + slight inner glow */
            box-shadow: inset 1px 1px 3px var(--shadow-dark), inset -1px -1px 3px var(--shadow-light), 0 0 0 2px #3b82f6;
        }

        /* Bright Neumorphic Button (for contrast) */
        .neumorphic-button {
            background-color: #3b82f6; /* blue-500 */
            color: #ffffff;
            /* Outer shadow for raised look */
            box-shadow: 5px 5px 10px var(--shadow-dark), -5px -5px 10px var(--shadow-light); 
            transition: all 0.2s ease-in-out;
        }

        .neumorphic-button:hover {
            box-shadow: 2px 2px 5px var(--shadow-dark), -2px -2px 5px var(--shadow-light);
            transform: translateY(1px);
        }

        .neumorphic-button:active {
            /* Inset shadow for click effect */
            box-shadow: inset 3px 3px 6px #2563eb, inset -3px -3px 6px #4a8dfa;
            transform: translateY(2px);
        }

        /* Gradient for icons */
        .icon-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, #3B82F6, #2563EB); 
        }

        /* Specific styling for Archive items to respect theme */
        .article-item:hover {
            background-color: var(--article-bg-hover);
        }
    </style>
<body class="bg-slate-100 min-h-screen">

    <!-- Header containing the theme toggle -->
    <header class="max-w-7xl mx-auto flex justify-end p-4">
        <button id="theme-toggle" class="neumorphic-button flex items-center px-4 py-2 text-sm">
            <i class="fas fa-moon mr-2" id="moon-icon"></i>
            <i class="fas fa-sun mr-2 hidden" id="sun-icon"></i>
            <span id="theme-text">Dark Mode</span>
        </button>
    </header>

    <!-- Tabbed Navigation Bar -->
    <nav id="tab-nav" class="nav-gradient shadow-xl w-full sticky top-0 z-10">
        <div id="tab-container" class="max-w-7xl mx-auto flex flex-wrap lg:flex-nowrap justify-center overflow-x-auto nav-scrollable">

            <!-- Tab 1: Home (Active by default) -->
            <button data-tab="home" class="tab-button flex items-center p-3 text-white transition duration-300 hover:bg-white/20 active-tab">
                <i class="fas fa-home mr-2"></i>
                <span class="text-sm font-medium whitespace-nowrap">Home</span>
            </button>

            <!-- Tab 2: Editorial Board -->
            <button data-tab="editorial" class="tab-button flex items-center p-3 text-white transition duration-300 hover:bg-white/20">
                <i class="fas fa-users mr-2"></i>
                <span class="text-sm font-medium whitespace-nowrap">Editorial Board</span>
            </button>

            <!-- Tab 3: Author Guidelines -->
            <button data-tab="guidelines" class="tab-button flex items-center p-3 text-white transition duration-300 hover:bg-white/20">
                <i class="fas fa-book-open mr-2"></i>
                <span class="text-sm font-medium whitespace-nowrap">Author Guidelines</span>
            </button>

            <!-- Tab 4: Publication Ethics -->
            <button data-tab="ethics" class="tab-button flex items-center p-3 text-white transition duration-300 hover:bg-white/20">
                <i class="fas fa-balance-scale mr-2"></i>
                <span class="text-sm font-medium whitespace-nowrap">Publication Ethics</span>
            </button>

            <!-- Tab 5: Submission -->
            <button data-tab="submission" class="tab-button flex items-center p-3 text-white transition duration-300 hover:bg-white/20">
                <i class="fas fa-upload mr-2"></i>
                <span class="text-sm font-medium whitespace-nowrap">Submission</span>
            </button>

            <!-- Tab 6: Archive -->
            <button data-tab="archive" class="tab-button flex items-center p-3 text-white transition duration-300 hover:bg-white/20">
                <i class="fas fa-box-archive mr-2"></i>
                <span class="text-sm font-medium whitespace-nowrap">Archive</span>
            </button>

            <!-- Tab 7: Articles in Press -->
            <button data-tab="articles" class="tab-button flex items-center p-3 text-white transition duration-300 hover:bg-white/20">
                <i class="fas fa-newspaper mr-2"></i>
                <span class="text-sm font-medium whitespace-nowrap">Articles in Press</span>
            </button>

            <!-- Tab 8: Contact Us -->
            <button data-tab="contact" class="tab-button flex items-center p-3 text-white transition duration-300 hover:bg-white/20">
                <i class="fas fa-envelope mr-2"></i>
                <span class="text-sm font-medium whitespace-nowrap">Contact Us</span>
            </button>

        </div>
    </nav>

    <!-- Tab Content Area -->
    <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

        <!-- Content 1: Home -->
        <div id="content-home" class="tab-content neumorphic p-6 rounded-xl shadow-md border-t-4 border-blue-600">
            <div class="container mx-auto px-4 py-8 md:py-16">
        <!-- Main grid layout for content and sidebar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left-hand side content section -->
            <div class="md:col-span-2 space-y-12">
                <!-- Header Section -->
                <div class="neumorphic p-8 rounded-xl">
                    <h1 class="text-2xl md:text-4xl font-extrabold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500" style="font-family: 'Lora', serif;">Global Journal of Clinical Medicine</h1>
                    <div class="text-lg space-y-2 text-gray-700">
                        <p class="font-semibold text-gray-900">Journal Cite Score: <span class="text-gray-900 font-normal">1.61</span></p>
                        <p class="font-semibold text-gray-900">Journal Impact Factor: <span class="text-gray-900 font-normal">3.1</span></p>
                        <p class="font-semibold text-gray-900">Journal Acceptance to Publication Time: <span class="text-gray-900 font-normal">07-25 days</span></p>
                        <p class="font-semibold text-gray-900">Average Article Processing Time: <span class="text-gray-900 font-normal">10-20 days</span></p>
                        <p class="font-semibold text-gray-900">Journal h-index: <span class="text-gray-900 font-normal">8</span></p>
                        <p class="font-semibold text-gray-900">Please submit article at <a href="mailto:publish@probejournals.com" class="text-blue-600 hover:underline">publish@probejournals.com</a></p>
                    </div>
                    <p class="mt-6 leading-relaxed">
                        Global Journal of Clinical Medicine (JCM) is an academic, online, open Access, double-blind peer- reviewed, multidisciplinary area of clinical medicine, the journal focused on both clinical and basic science studies. The journal accepting type of articles like Research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc. Our goal is to persuade scientists to publish their theoretical and experimental findings in as much detail as they can.</p>
                </div>

                <!-- Aim and Scope Section -->
                <div class="space-y-6">
                    <h2 class="text-3xl font-semibold text-gray-900">Aim and scope</h2>
                    <p class="leading-relaxed">
                        The Global Journal of Clinical Medicine aims to support the global scientific and medical community by encouraging the publication of both experimental and theoretical research in complete detail, ensuring that every study is reproducible, transparent, and scientifically sound.

</p>
                    <p class="leading-relaxed">
                        Our mission is to promote excellence in clinical science by providing an open-access platform for high-quality research that enhances understanding of disease mechanisms, diagnostics, and therapeutic practices. The journal welcomes manuscripts reporting significant findings from any area of clinical or pre-clinical medicine, particularly those that contribute meaningful advancements or offer broad relevance to healthcare professionals and researchers.
                    </p>
                    <p class="leading-relaxed">
                        The journal accepting type of articles like research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc.
                    </p>
                    
                    <p class="leading-relaxed">
                        This journal covers all topics related to clinical and pre-clinical practices. Topics of interest include (but are not limited to):</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Cardiology</li>
                        <li>Gastroenterology & Hepatopancreatobiliary Medicine</li>
                        <li>Clinical Neurology</li>
                        <li>Oncology</li>
                        <li>Orthopedics</li>
                        <li>Endocrinology & Metabolism</li>
                        <li>Nephrology & Urology</li>
                        <li>Epidemiology & Public Health</li>
                        <li>Stomatology</li>
                        <li>Pulmonology</li>
                        <li>Ophthalmology</li>
                        <li>Obstetrics & Gynecology</li>
                        <li>Immunology</li>
                        <li>Hematology</li>
                        <li>Clinical Psychology & Psychiatry</li>
                        <li>Otolaryngology</li>
                        <li>Dermatology</li>
                        <li>Clinical Pharmacology</li>
                    </ul>
                    <p class="leading-relaxed">
                        All Articles of Clinical Medicine publications are made freely and permanently available online as soon as they are published, without any subscription fees or registration requirements.
                    </p>
                </div>

                <!-- Privacy Statement Section -->
                <div class="space-y-4">
                    <h2 class="text-3xl font-semibold text-gray-900">Privacy Statement</h2>
                    <p class="leading-relaxed">
                        The names and email addresses entered in this journal site will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.
                    </p>
                </div>
            </div>

            <!-- Right-hand side sidebar section -->
            <div class="space-y-8">
                <!-- Articles Count -->
                <div class="neumorphic p-6 rounded-xl">
                    <p class="text-gray-700">OA articles count: <span class="font-semibold text-gray-900">102</span></p>
                    <p class="text-gray-700">OA journals count: <span class="font-semibold text-gray-900">7</span></p>
                </div>

                <!-- Journals By Subject -->
                <div class="neumorphic p-6 rounded-xl">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Journals By Subject</h3>
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <p class="font-semibold text-gray-700">Clinical Sciences</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li><a href="https://probejournals.com/journal-of-clinical-trials-and-case-studies/" class="hover:underline text-blue-600">Journal of Clinical Trials and Case Studies</a></li>
                                <li><a href="https://probejournals.com/trends-in-diabetes-obesity-and-metabolism-tdom/" class="hover:underline text-blue-600">Trends in Diabetes, Obesity and Metabolism</a></li>
                            </ul>
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold text-gray-700">Medical Sciences</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li><a href="https://probejournals.com/journal-of-clinical-medicine/" class="hover:underline text-blue-600">Global Journal of Clinical Medicine</a></li>
                                <li><a href="https://probejournals.com/journal-of-diseases/" class="hover:underline text-blue-600">Journal of Diseases</a></li>
                                <li><a href="https://probejournals.com/journal-of-infectious-diseases-therapy/" class="hover:underline text-blue-600">Journal of Infectious Diseases & Therapy</a></li>
                                <li><a href="https://probejournals.com/journal-of-neurology/" class="hover:underline text-blue-600">Research Journal of Neurology</a></li>
                            </ul>
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold text-gray-700">General Sciences</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li><a href="https://probejournals.com/journal-of-biology/" class="hover:underline text-blue-600">Journal of Biology</a></li>
                                <li><a href="https://probejournals.com/research-in-microbiology-and-biotechnology-rmb/" class="hover:underline text-blue-600">Research in Microbiology and Biotechnology (RMB)</a></li>
                            </ul>
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold text-gray-700">Engineering Journals</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                <li>International Journal of Computer Sciences (will be added soon)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Article Statistics -->
                <div class="neumorphic p-6 rounded-xl">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900 text-center">Article Statistics</h3>
                    <!-- SVG Pie Chart -->
                    <div class="flex justify-center">
                        <svg viewBox="0 0 260 260" role="img" aria-label="Pie chart">
                        <!-- Red slice — 40.89% -->
                        <path d="M 130,130 L 130.000,30.000 A 100,100 0 0,1 184.165,214.060 Z" fill="#ef4444" />

                        <!-- Green slice — 28.41% -->
                        <path d="M 130,130 L 184.165,214.060 A 100,100 0 0,1 36.345,165.053 Z" fill="#10b981" />

                        <!-- Blue slice — 30.09% -->
                        <path d="M 130,130 L 36.345,165.053 A 100,100 0 0,1 126.168,30.073 Z" fill="#3b82f6" />

                        <!-- Optional stroke between slices -->
                        <g stroke="#e5e7eb" stroke-width="1.5">
                            <path d="M 130,130 L 130.000,30.000 A 100,100 0 0,1 184.165,214.060 Z" fill="none"/>
                            <path d="M 130,130 L 184.165,214.060 A 100,100 0 0,1 36.345,165.053 Z" fill="none"/>
                            <path d="M 130,130 L 36.345,165.053 A 100,100 0 0,1 126.168,30.073 Z" fill="none"/>
                        </g>

                        <!-- Labels (positioned inside each slice) -->
                        <text x="187.56" y="113.06" text-anchor="middle" fill="#fff">40.89%</text>
                        <text x="111.12" y="186.95" text-anchor="middle" fill="#fff">28.41%</text>
                        <text x="80.05" y="96.76" text-anchor="middle" fill="#fff">30.09%</text>

                        <!-- Optional center label -->
                        <circle cx="130" cy="130" r="28" fill="var(--bg-body)"/> <!-- Dynamic background -->
                        <text x="130" y="135" text-anchor="middle" fill="var(--text-heading)">99.39%</text> <!-- Dynamic text -->
                        </svg>
                    </div>
                    <p class="text-center text-gray-600 text-sm mt-4">
                        <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-1"></span>Accepted Article <br> (28.41%)
                        <span class="inline-block w-2 h-2 rounded-full bg-red-500 ml-4 mr-1"></span>Rejected Article <br> (40.89%)
                        <span class="inline-block w-2 h-2 rounded-full bg-blue-500 ml-4 mr-1"></span>Submitted Article <br> (30.09%)
                    </p>
                </div>

                <!-- Current Issue Highlights -->
                <div class="neumorphic p-6 rounded-xl">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Current Issue Highlights</h3>
                    <div class="space-y-6">
                        <!-- Highlight 1 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: Mukul Machhindra Barwant, Akshay Darandale, Vishnu Jadhav and Ruchita Shrivastava</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/JB-118.pdf" class="text-blue-600 hover:underline font-semibold">Manual for Studying of Morphology and Anatomy of Angiospermic Plants</a>
                        </div>
                        <!-- Highlight 2 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: Sinhad Hossain Fahim, Ahmed Abdal Shafi Rasel, Abdur Rahman Sarker, Tanzia Chowdhury</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/jb-12.pdf" class="text-blue-600 hover:underline font-semibold">Bangla License Plate Detection Using YOLO V8 Model</a>
                        </div>
                        <!-- Highlight 3 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: Aboolghasem Amri Sahebi1, Babak Doushtshenas1, Reza Safari 2, *, Arash Larki1</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/Retracted.pdf" class="text-blue-600 hover:underline font-semibold">Assessment of Biosorption and Transfer of Heavy Metals...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="neumorphic mt-16 md:mt-24 text-center p-8 rounded-xl overflow-hidden">
            <h2 class="text-3xl font-semibold text-gray-900 mb-8">Associated and indexed with</h2>
            <!-- The scrolling container -->
            <div class="overflow-hidden relative w-full bg-gray-100/50 py-6 rounded-lg">
                <!-- Continuous scrolling wrapper -->
                <div class="flex animate-scroll space-x-8">
                <img src="/assets/uploads/journals/clinical-medicine.png" alt="Clinical Medicine" class="w-16 h-16 object-contain rounded bg-white shadow-md">
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide5-1.jpg" alt="Crossref" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P2\""'/>
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide3.jpg" alt="COPE" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P3\""'/>
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide1.jpg" alt="PubMed" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P4\""'/>
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide4-1.jpg" alt="Grammarly" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P5\""'/>
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide2.jpg" alt="PubMed Central" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P6\""'/>
                <!-- repeat again for seamless loop -->
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide1.jpg" alt="PubMed Central" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P1\""'/>
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide5-1.jpg" alt="Crossref" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P2\""'/>
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide3.jpg" alt="COPE" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P3\""'/>
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide1.jpg" alt="PubMed" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P4\""'/>
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide4-1.jpg" alt="Grammarly" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P5\""'/>
                <img src="https://probejournals.com/wp-content/uploads/2025/06/slide2.jpg" alt="PubMed Central" class="w-16 h-16 object-contain rounded bg-white shadow-md" onerror='this.onerror=null; this.src=\"https://placehold.co/64x64/f0f4f8/1e293b?text=P6\""'/>
                </div>
            </div>
        </div>
    </div>
        </div>

        <!-- Content 2: Editorial Board -->
        <div id="content-editorial" class="tab-content hidden neumorphic p-6 rounded-xl shadow-md border-t-4 border-blue-600">
           <div class="container mx-auto px-4 py-8 md:py-16">
        <!-- Editorial Board Section -->
        <div class="space-y-6">
            <h1 class="text-2xl md:text-4xl font-extrabold mb-8 text-center bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500" style="font-family: 'Lora', serif;">Editorial Board</h1>
            <div class="space-y-6">
                <!-- Editor Card 1: Dr. Abu-Hussein Muhamad -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start neumorphic p-6 rounded-xl space-y-4 sm:space-y-0 sm:space-x-6">
                    <img src="https://probejournals.com/wp-content/uploads/2025/06/e1.jpg" alt="Dr. Abu-Hussein Muhamad" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 onerror='this.onerror=null; this.src=\"https://placehold.co/128x128/f0f4f8/1e293b?text=AHM\"'">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Dr. Abu-Hussein Muhamad</h3>
                        <p class="text-gray-700">Editor in Chief</p>
                        <p class="text-sm text-gray-600">Department of Pediatric Dentistry,</p>
                        <p class="text-sm text-gray-600">Aesthetics Dental Clinic,</p>
                        <p class="text-sm text-gray-600">Athens, Greece</p>
                    </div>
                </div>
                <!-- Editor Card 2: Dr. Alireza Heidari -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start neumorphic p-6 rounded-xl space-y-4 sm:space-y-0 sm:space-x-6">
                    <img src="https://probejournals.com/wp-content/uploads/2025/06/e6.jpg" alt="Dr. Alireza Heidari" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 onerror='this.onerror=null; this.src=\"https://placehold.co/128x128/f0f4f8/1e293b?text=AH\"'">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Dr. Alireza Heidari</h3>
                        <p class="text-gray-700">Editor in chief</p>
                        <p class="text-sm text-gray-600">Faculty of Chemistry,</p>
                        <p class="text-sm text-gray-600">California South University (CSU),</p>
                        <p class="text-sm text-gray-600">Irvine, California, USA</p>
                    </div>
                </div>
                <!-- Editor Card 3: Dr. Shrikant Charde -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start neumorphic p-6 rounded-xl space-y-4 sm:space-y-0 sm:space-x-6">
                    <img src="https://probejournals.com/wp-content/uploads/2025/06/e8.jpg" alt="Dr. Shrikant Charde" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 onerror='this.onerror=null; this.src=\"https://placehold.co/128x128/f0f4f8/1e293b?text=SC\"'">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Dr. Shrikant Charde</h3>
                        <p class="text-gray-700">Editor in Chief</p>
                        <p class="text-sm text-gray-600">Vice President,</p>
                        <p class="text-sm text-gray-600">Department of Clinical Pharmacology,</p>
                        <p class="text-sm text-gray-600">Allucent, Cary, United States</p>
                    </div>
                </div>
                <!-- Editor Card 4: Dr. Jyothi Victoria -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start neumorphic p-6 rounded-xl space-y-4 sm:space-y-0 sm:space-x-6">
                    <img src="https://probejournals.com/wp-content/uploads/2025/06/e2.jpg" alt="Dr. Jyothi Victoria" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 onerror='this.onerror=null; this.src=\"https://placehold.co/128x128/f0f4f8/1e293b?text=JV\"'">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Dr. RobertoDe Vivo</h3>
                        <p class="text-gray-700">Editor</p>
                        <p class="text-sm text-gray-600">Department of Veterinary Medicine and Animal Production,</p>
                        <p class="text-sm text-gray-600">University of Naples “Federico II”</p>
                        <p class="text-sm text-gray-600">Italy</p>
                    </div>
                </div>
                <!-- Editor Card 5: Dr. Yi Huang -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start neumorphic p-6 rounded-xl space-y-4 sm:space-y-0 sm:space-x-6">
                    <img src="https://probejournals.com/wp-content/uploads/2025/06/e4.jpg" alt="Dr. Yi Huang" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 onerror='this.onerror=null; this.src=\"https://placehold.co/128x128/f0f4f8/1e293b?text=YH\"'">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Dr. Mukul Machhindra Barwant</h3>
                        <p class="text-gray-700">Editor</p>
                        <p class="text-sm text-gray-600">Department of Botany,</p>
                        <p class="text-sm text-gray-600">Sanjivani Arts Commerce and Science College ,</p>
                        <p class="text-sm text-gray-600">Maharshtra, India</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center sm:items-start neumorphic p-6 rounded-xl space-y-4 sm:space-y-0 sm:space-x-6">
                    <img src="https://probejournals.com/wp-content/uploads/2025/06/e5.jpg" alt="Dr. Yi Huang" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 onerror='this.onerror=null; this.src=\"https://placehold.co/128x128/f0f4f8/1e293b?text=YH\"'">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Dr. Sukalyan Kumar Kundu</h3>
                        <p class="text-gray-700">Editor</p>
                        <p class="text-sm text-gray-600">Department of Pharmacy,</p>
                        <p class="text-sm text-gray-600">Jahangirnagar University,</p>
                        <p class="text-sm text-gray-600">Dhaka, Bangladesh</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center sm:items-start neumorphic p-6 rounded-xl space-y-4 sm:space-y-0 sm:space-x-6">
                    <img src="https://probejournals.com/wp-content/uploads/2025/06/e7.jpg" alt="Dr. Yi Huang" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 onerror='this.onerror=null; this.src=\"https://placehold.co/128x128/f0f4f8/1e293b?text=YH\"'">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Dr. Yi Huang</h3>
                        <p class="text-gray-700">Sr. Statistical Data Analyst</p>
                        <p class="text-gray-700">Editor</p>
                        <p class="text-sm text-gray-600">Radiation Oncology,</p>
                        <p class="text-sm text-gray-600">Washington University,</p>
                        <p class="text-sm text-gray-600">Missouri, United States</p>
                    </div>
                </div>
                
                <!-- Editor Card 7: Dr. Chieh Chen -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start neumorphic p-6 rounded-xl space-y-4 sm:space-y-0 sm:space-x-6">
                    <img src="https://probejournals.com/wp-content/uploads/2025/06/e19.jpg" alt="Dr. Chieh Chen" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 onerror='this.onerror=null; this.src=\"https://placehold.co/128x128/f0f4f8/1e293b?text=CC\"'">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Dr. Chieh Chen</h3>
                        <p class="text-gray-700">Editor</p>
                        <p class="text-sm text-gray-600">Division of Family Medicine</p>
                        <p class="text-sm text-gray-600">Hualien Armed Forces General Hospital,</p>
                        <p class="text-sm text-gray-600">Taiwan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>

        <!-- Content 3: Author Guidelines -->
        <div id="content-guidelines" class="tab-content hidden neumorphic p-6 rounded-xl shadow-md border-t-4 border-blue-600">
            <!-- Main content wrapper -->
    <div class="container mx-auto px-4 py-8 md:py-16">
        <!-- Main grid layout for content and sidebar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left-hand side content section -->
            <div class="md:col-span-2 space-y-12">
                <!-- Header Section -->
                <div class="neumorphic p-8 rounded-xl">
                    <div class="text-lg space-y-2 text-gray-700">
                        <p class="font-semibold text-gray-900">Covered Areas: <span class="text-gray-900 font-normal">Multidisciplinary</span></p>
                        <p class="font-semibold text-gray-900">Issue release frequency: <span class="text-gray-900 font-normal">Bimonthly</span></p>
                        <p class="font-semibold text-gray-900">Publishing time of manuscripts: <span class="text-gray-900 font-normal">15-25 days</span></p>
                    </div>
                    <h1 class="text-2xl md:text-2xl font-extrabold mb-4 mt-6 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500" style="font-family: 'Lora', serif;">Author Guidelines</h1>
                    <p class="mt-6 leading-relaxed">The Global Journal of Clinical Medicine accepts papers of high quality in any area of biology and biological sciences provided they have a strong claim to general interest. This could be because the discovery represents a major advance within a specific field or because it holds inherent interest for the wider biological community. </p>
                    <p class="mt-6 leading-relaxed">The journal accepting type of articles like research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc.</p>
                    <h3 class="text-xl font-semibold text-gray-900">Article Processing Charges (APC)</h3>
                    <p class="mt-6 leading-relaxed">Our journals are not receiving any kind of financial support. The journal not charging any kind of subscription/submission fee, but we charge the fee.</p>
                    <p class="mt-4 leading-relaxed">For all kind of articles, the Article Processing Charges (APC) would be EUR 1019.</p>
                    <h3 class="text-xl font-semibold text-gray-900">Author Withdrawl Policy</h3>
                    <p class="mt-6 leading-relaxed">We are not charging any kind of withdrawal fee if the authors want to withdraw the article within 3-5 days. If the authors want to withdraw the article after 5 days, we will charge EUR 219 as a withdrawal fee.</p>
                    
                    <p class="mt-6 leading-relaxed">
                        After submitting articles, authors will get all regular updates of the articles. Updates will include preliminary quality analysis, reviewer comments, editor decision, publishing of the article etc. Galley proof will be done in standard formats, followed by preparation of pdf, full text etc.
                    </p>
                    <p class="mt-4 leading-relaxed">
                        Accepted articles will be published within 20-25 days. Journal of Biology welcomes direct submissions of manuscripts from authors. You can submit article at <a href="mailto:publish@probejournals.com" class="text-blue-600 hover:underline">publish@probejournals.com</a>
                    </p>
                    <p class="mt-4 leading-relaxed">
                        We will publish only fresh articles, so please make sure that your articles are not published anywhere. We have tools, resources and services to help you at each stage of the publication journey to enable you to research, write, publish, promote and track your article. Let us help you make the most out of your next publication!
                    </p>
                </div>
            </div>
            <!-- Right-hand side sidebar section -->
            <div class="space-y-8 md:col-span-1">
                <!-- Current Issue Highlights -->
                <div class="neumorphic p-6 rounded-xl">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Current Issue Highlights</h3>
                    <div class="space-y-6">
                        <!-- Highlight 1 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: Xinge Diana Zhang*, Xuefei Bai, Claudia Teng</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/JCTCS-137-Revised.pdf" class="text-blue-600 hover:underline font-semibold">Nanodiamond-Zinc Oxide (ND-ZnO): A Multifunctional Molecule for Skin Regeneration</a>
                        </div>
                        <!-- Highlight 2 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: A Murali</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/JCTCS-134-fn.pdf" class="text-blue-600 hover:underline font-semibold">Antibiotic Use and Resistance Awareness, Knowledge, and Attitude among Lebanese Population: A cross-sectional survey</a>
                        </div>
                        <!-- Highlight 3 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: Calvin Johnson</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/JCRCS-135.pdf" class="text-blue-600 hover:underline font-semibold">COVID-19 Vaccination Attitudes among Healthcare Workers, and Educators</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full-width content section for "Type of articles" -->
        <div class="w-full space-y-12 mt-12">
            
            <!-- General Instructions -->
            <div class="neumorphic p-6 rounded-xl space-y-4">
                <h3 class="text-xl font-semibold text-gray-900">General Instructions</h3>
                <p class="leading-relaxed">
                    <span class="font-semibold text-gray-900">Covering Letter:</span> All submissions must include a covering letter specifying the manuscript type (e.g., Research Article, Review Article, Brief Report, Case Study, etc.). Authors may not categorize submissions as Editorials, Letters to the Editor, or Concise Communications unless specifically invited by the editorial office.
                </p>
                <p class="leading-relaxed">
                    <span class="font-semibold text-gray-900">Authorship Compliance:</span> Ensure that all listed authors meet the journal's authorship criteria as outlined by Journal.
                </p>
                <p class="leading-relaxed">
                    <span class="font-semibold text-gray-900">Exclusivity:</span> Manuscripts must not be under review or consideration by any other journal at the time of submission.
                </p>
                <p class="leading-relaxed">
                    <span class="font-semibold text-gray-900">Conflict of Interest & Financial Disclosure:</span> Clearly disclose any financial support from commercial sources or other potential conflicts of interest. Any competing interests should also be addressed upon publication.
                </p>
            </div>
            <!-- Manuscript Formatting -->
            <div class="neumorphic p-6 rounded-xl space-y-4">
                <h3 class="text-xl font-semibold text-gray-900">Title Page Requirements:</h3>
                <p class="leading-relaxed">
                    Include a clear title and detailed author information on the title page.
                </p>
                <h4 class="text-lg font-semibold text-gray-900">Author details should include:</h4>
                <ul class="list-disc list-inside space-y-1 ml-4">
                    <li>Full Name</li>
                    <li>Institutional affiliation</li>
                    <li>Academic qualifications</li>
                    <li>Contact information</li>
                </ul>
                <p class="leading-relaxed mt-4">
                    The corresponding author must provide a complete mailing address, telephone number, fax number, and email address.
                </p>
            </div>
            <!-- Manuscript Formatting -->
            <div class="neumorphic p-6 rounded-xl space-y-4">
                <h3 class="text-xl font-semibold text-gray-900">Manuscript Formatting:</h3>
                <p class="leading-relaxed">
                    Paginate all pages sequentially, including references, tables, and figure legends.
                </p>
                <p class="leading-relaxed">
                    Page 1 should be the title page, including:
                </p>
                <ul class="list-disc list-inside space-y-1 ml-4">
                    <li>Short running title (no acronyms)</li>
                    <li>Full title</li>
                    <li>Authors' names and academic degrees</li>
                    <li>Funding acknowledgments</li>
                    <li>Contact details for correspondence and reprint requests</li>
                </ul>
            </div>
            <!-- Manuscript Categories & Guidelines -->
            <h2 class="text-3xl font-semibold text-gray-900">Manuscript Categories & Guidelines</h2>
            <div class="space-y-6">
                <!-- 1. Research Articles -->
                <div class="neumorphic p-6 rounded-xl space-y-4">
                    <h3 class="text-xl font-semibold text-gray-900">1. Research Articles</h3>
                    <p class="leading-relaxed">
                        Based on original empirical or secondary data using a defined research methodology.
                    </p>
                    <p class="leading-relaxed">
                        Must contribute new knowledge to the field of journal.
                    </p>
                    <p class="leading-relaxed">
                        Include a minimum 300-word abstract structured into: Objective, Methods, Results, and Conclusion, with 7–10 keywords.
                    </p>
                    <h4 class="text-lg font-semibold text-gray-900">Structure:</h4>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>Introduction</li>
                        <li>Literature Review</li>
                        <li>Methodology</li>
                        <li>Results & Discussion</li>
                        <li>Conclusion</li>
                        <li>References, Tables, and Figure Legends</li>
                    </ul>
                </div>
                <!-- 2. Review Articles -->
                <div class="neumorphic p-6 rounded-xl space-y-4">
                    <h3 class="text-xl font-semibold text-gray-900">2. Review Articles</h3>
                    <p class="leading-relaxed">
                        Based on secondary data relevant to the journal's scope.
                    </p>
                    <p class="leading-relaxed">
                        Provide a critical overview of a specific topic.
                    </p>
                    <h4 class="text-lg font-semibold text-gray-900">Include:</h4>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>300-word abstract</li>
                        <li>Relevant keywords</li>
                        <li>Introduction to the topic</li>
                        <li>Analytical discussion with appropriate visual aids</li>
                        <li>Summary and conclusion</li>
                        <li>Full references</li>
                    </ul>
                </div>
                <!-- 3. Commentaries -->
                <div class="neumorphic p-6 rounded-xl space-y-4">
                    <h3 class="text-xl font-semibold text-gray-900">3. Commentaries</h3>
                    <p class="leading-relaxed">
                        Brief opinion pieces by subject matter experts discussing current advancements or developments.
                    </p>
                    <h4 class="text-lg font-semibold text-gray-900">Include:</h4>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>Title and abstract with keywords</li>
                        <li>Direct analysis of the issue with optional figures/tables</li>
                        <li>Conclusion and references</li>
                    </ul>
                </div>
                <!-- 4. Case Studies -->
                <div class="neumorphic p-6 rounded-xl space-y-4">
                    <h3 class="text-xl font-semibold text-gray-900">4. Case Studies</h3>
                    <p class="leading-relaxed">
                        Present detailed reports of individual cases that provide new insights in topic Format:
                    </p>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>Cases and Methods section (describing the clinical issue and approach)</li>
                        <li>Discussion</li>
                        <li>Conclusion</li>
                    </ul>
                </div>
                <!-- 5. Editorials -->
                <div class="neumorphic p-6 rounded-xl space-y-4">
                    <h3 class="text-xl font-semibold text-gray-900">5. Editorials</h3>
                    <p class="leading-relaxed">
                        Short commentaries on recently published research or journal issues.
                    </p>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>Only accepted upon invitation from the editorial office.</li>
                        <li>Must be submitted within three weeks of the invitation.</li>
                    </ul>
                </div>
                <!-- 6. Clinical Images -->
                <div class="neumorphic p-6 rounded-xl space-y-4">
                    <h3 class="text-xl font-semibold text-gray-900">6. Clinical Images</h3>
                    <p class="leading-relaxed">
                        Photographic depictions relevant to topic (maximum 5 figures).
                    </p>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>Must be accompanied by a description (max 300 words).</li>
                        <li>No separate figure legends or references required (up to 3 references if necessary).</li>
                        <li>Accepted formats: .TIFF (preferred) or .EPS.</li>
                    </ul>
                </div>
                <!-- 7. Letters to the Editor / Concise Communications -->
                <div class="neumorphic p-6 rounded-xl space-y-4">
                    <h3 class="text-xl font-semibold text-gray-900">7. Letters to the Editor / Concise Communications</h3>
                    <p class="leading-relaxed">
                        Commentaries on previously published articles.
                    </p>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>Must be concise and directly address issues or findings presented in the original article.</li>
                        <li>No abstract or subheadings required.</li>
                        <li>Should be submitted within six months of the article's publication.</li>
                    </ul>
                    <p class="leading-relaxed">
                        Please ensure all submissions adhere to these guidelines to facilitate a smooth review process.
                    </p>
                    <p class="leading-relaxed">
                        For questions, contact the editorial office.
                    </p>
                    </div>
                <div class="neumorphic p-6 rounded-xl space-y-4">
                    
                    <h3 class="text-xl font-semibold text-gray-900">Copyrights</h3>
                    <p class="mt-6 leading-relaxed">The journal retains the copyright and any extensions or renewals thereof worldwide. This includes, but is not limited to, the rights to publish, disseminate, transmit, store, translate, distribute, sell, republish, and use the contribution and its contents in both print and electronic formats, as well as in derivative works. These rights apply across all languages and media formats, now known or developed in the future. The journal also reserves the right to license or permit others to exercise these rights.</p>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Content 4: Publication Ethics -->
        <div id="content-ethics" class="tab-content hidden neumorphic p-6 rounded-xl shadow-md border-t-4 border-red-600">
           <div class="container mx-auto px-4 py-8 md:py-16">
        <!-- Main grid layout for content and sidebar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left-hand side content section -->
            <div class="md:col-span-2 space-y-12">
                <!-- Header Section -->
                <div class="neumorphic p-8 rounded-xl">
                    <h1 class="text-2xl md:text-4xl lg:text-3xl font-extrabold mb-4 mt-6 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500" style="font-family: 'Lora', serif;">Publication Ethics and Malpractice Guidelines</h1>
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900 mt-6">Responsibilities of the editors</h2>
                    <p class="mt-4 leading-relaxed">
                        This Journal is always a collaborative effort. Managing challenges of research integrity and publishing ethics in journal is no exception. Legal concerns may arise as a result of these issues. We recommend that journal use these principles as a starting point for developing policies and processes, as well as when dealing with problems.
                    </p>
                    <p class="mt-4 leading-relaxed">
                        We recommend that editors, publishers, and other journal team members discuss the concerns raised as a first step in addressing any issue. We recommend that these discussions take place before taking any further action, and that legal advice be obtained if necessary, especially when matters involve potential defamation, violation of contract, privacy, or copyright infringement.
                    </p>

                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900 mt-6">Confidentiality</h2>
                    <p class="mt-4 leading-relaxed">
                        The corresponding author, reviewers, potential reviewers, other editorial advisers, and the publisher, as appropriate, are the only people who should know about a manuscript that has been submitted to them.
                    </p>

                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900 mt-6">Responsibilities of reviewers</h2>
                    <p class="mt-4 leading-relaxed">
                        The peer-reviewing process helps the editor and editorial board make editorial judgments, and it may also help the author improve their manuscript. Any referee who feels unqualified to examine the research described in a paper or understands that timely review is impossible should inform the editor and withdraw from the review process. Manuscripts submitted for review must be treated as private papers. They must not be shared or discussed with anyone else unless the editor has given permission.
                    </p>
                </div>
            </div>
            <!-- Right-hand side sidebar section -->
            <div class="space-y-8 md:col-span-1">
                <!-- Current Issue Highlights -->
                <div class="neumorphic p-6 rounded-xl">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Current Issue Highlights</h3>
                    <div class="space-y-6">
                        <!-- Highlight 1 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: Xinge Diana Zhang*, Xuefei Bai, Claudia Teng</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/JCTCS-137-Revised.pdf" class="text-blue-600 hover:underline font-semibold">Nanodiamond-Zinc Oxide (ND-ZnO): A Multifunctional Molecule for Skin Regeneration</a>
                        </div>
                        <!-- Highlight 2 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: A Murali</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/JCTCS-134-fn.pdf" class="text-blue-600 hover:underline font-semibold">Antibiotic Use and Resistance Awareness, Knowledge, and Attitude among Lebanese Population: A cross-sectional survey</a>
                        </div>
                        <!-- Highlight 3 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: Calvin Johnson</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/JCRCS-135.pdf" class="text-blue-600 hover:underline font-semibold">COVID-19 Vaccination Attitudes among Healthcare Workers, and Educators</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>

        <!-- Content 5: Submission -->
        <div id="content-submission" class="tab-content hidden neumorphic p-6 rounded-xl shadow-md border-t-4 border-green-600">
            <!-- Main content wrapper -->
    <div class="container mx-auto px-4 py-8 md:py-16">
        <!-- Main grid layout for content and sidebar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left-hand side content section -->
            <div class="md:col-span-2 space-y-12">
                <!-- Main Content Section -->
                <div class="neumorphic p-8 rounded-xl">
                    <h1 class="text-2xl md:text-4xl lg:text-3xl font-extrabold mb-4 mt-6 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500" style="font-family: 'Lora', serif;">Submit Manuscript</h1>
                    <p class="mt-4 leading-relaxed">
                        The Global Journal of Clinical Medicine accepts papers of high quality in any area of biology and biological sciences.
                    </p>
                    <p class="mt-4 leading-relaxed">
                        The journal accepting type of articles like research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc.
                    </p>
                    <p class="mt-4 leading-relaxed">
                        Submit manuscript at <a href="https://probejournals.com/submissions/" class="text-blue-600 hover:underline">Online Submission</a> System or send as an e-mail attachment to the Editorial Office at <a href="mailto:publish@probejournals.com" class="text-blue-600 hover:underline">publish@probejournals.com</a>
                    </p>
                    <p class="mt-4 leading-relaxed">
                        After submitting articles, authors will get all regular updates of the articles. Updates will include preliminary quality analysis, reviewer comments, editor decision, publishing of the article etc. Galley proof will be done in standard formats, followed by preparation of pdf, full text etc.
                    </p>
                    <p class="mt-4 leading-relaxed">
                        Accepted articles will be published approximately in 20 days.
                    </p>
                </div>
            </div>
            <!-- Right-hand side sidebar section -->
            <div class="space-y-8 md:col-span-1">
                <!-- Current Issue Highlights (Duplicate for layout consistency) -->
                <div class="neumorphic p-6 rounded-xl">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Current Issue Highlights</h3>
                    <div class="space-y-6">
                        <!-- Highlight 1 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: Xinge Diana Zhang*, Xuefei Bai, Claudia Teng</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/JCTCS-137-Revised.pdf" class="text-blue-600 hover:underline font-semibold">Nanodiamond-Zinc Oxide (ND-ZnO): A Multifunctional Molecule for Skin Regeneration</a>
                        </div>
                        <!-- Highlight 2 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: A Murali</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/JCTCS-134-fn.pdf" class="text-blue-600 hover:underline font-semibold">Antibiotic Use and Resistance Awareness, Knowledge, and Attitude among Lebanese Population: A cross-sectional survey</a>
                        </div>
                        <!-- Highlight 3 -->
                        <div class="space-y-1">
                            <p class="text-sm text-gray-600">AUTHORS: Calvin Johnson</p>
                            <a href="https://probejournals.com/wp-content/uploads/2025/06/JCRCS-135.pdf" class="text-blue-600 hover:underline font-semibold">COVID-19 Vaccination Attitudes among Healthcare Workers, and Educators</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div></div>

        <!-- Content 6: Archive (Reverted to Coming Soon) -->
        <div id="content-archive" class="tab-content hidden neumorphic p-6 rounded-xl shadow-md border-t-4 border-yellow-600">
           <div class="container mx-auto px-4 py-8 md:py-16">
        <!-- Main content section with full width -->
        <!-- Main content section with full width -->
        <div class="md:col-span-3 space-y-12">
            <!-- Main Content Section -->
            <div class="neumorphic p-8 rounded-xl">
                <h1 class="text-2xl md:text-4xl lg:text-3xl font-extrabold mb-4 mt-6 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500" style="font-family: 'Lora', serif;">Journal Archives</h1>
                
                <!-- Collapsible Volume Sections -->
                <div class="space-y-6">
                    <!-- Volume 5 Section -->
                     <div class="neumorphic rounded-xl overflow-hidden">
                                        <div class="p-4 md:p-6 cursor-pointer flex justify-between items-center toggle-volume" data-target="volume-6">
                                            <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Volume 5</h2>
                                            <svg class="w-6 h-6 transform transition-transform duration-300 arrow-icon text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                        <div id="volume-6" class="collapse-content">
                                            <div class="p-4 md:p-6 space-y-4 border-t border-gray-200">
                                                <div class="neumorphic p-4 md:p-8 rounded-xl text-center bg-gray-100">
                                                    <h3 class="text-xl font-semibold text-gray-900">Issue 1</h3>
                                                </div>
                                                <div class="space-y-6 text-gray-700 mt-6">
                                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <h4 class="font-semibold text-orange-600 text-lg">Research Article</h4>
                                                            <div class="flex items-center space-x-4 text-gray-600">
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 27</span>
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 6</span>
                                                            </div>
                                                        </div>
                                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Michel Smith</p>

                                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2026/04/JCM-5-25.pdf" target="_blank">A Prospective, Cross-Sectional, Multicenter Pilot Study to Assess the Efficacy of NerveVue: A Non-Invasive, Multi-Site Diagnostic Tool for Peripheral Artery Disease</a></h4>
                                                        <div class="mt-2 flex items-center space-x-2">
                                                            <a href="https://probejournals.com/wp-content/uploads/2026/04/JCM-5-25.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75-.788888888888889z" clip-rule="evenodd" /></svg></a>
                                                            <p class="text-sm">DOI</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="space-y-6 text-gray-700 mt-6">
                                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <h4 class="font-semibold text-orange-600 text-lg">Review Article</h4>
                                                            <div class="flex items-center space-x-4 text-gray-600">
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 27</span>
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 6</span>
                                                            </div>
                                                        </div>
                                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Valeria La Rosa Sanchez, Angela Anaid Rios Angulo</p>

                                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2026/04/GJCM-5-27.pdf" target="_blank">Understanding Brain Metastasis: from Molecular Mechanisms to Treatment Advances</a></h4>
                                                        <div class="mt-2 flex items-center space-x-2">
                                                            <a href="https://probejournals.com/wp-content/uploads/2026/04/GJCM-5-27.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75-.788888888888889z" clip-rule="evenodd" /></svg></a>
                                                            <p class="text-sm">DOI</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-y-6 text-gray-700 mt-6">
                                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <h4 class="font-semibold text-orange-600 text-lg">Research Article</h4>
                                                            <div class="flex items-center space-x-4 text-gray-600">
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 27</span>
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 6</span>
                                                            </div>
                                                        </div>
                                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Mariantonietta Ariani, Emanuele Bartoletti and Loredana Cavalieri</p>

                                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2026/04/JCM-5-20-1.pdf" target="_blank">Ultrasound-Based Evaluation and Dermoaesthetic Recommendations for Secondary Lymphedema after Mastectomy for Breast Cancer</a></h4>
                                                        <div class="mt-2 flex items-center space-x-2">
                                                            <a href="https://probejournals.com/wp-content/uploads/2026/04/JCM-5-20-1.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75-.788888888888889z" clip-rule="evenodd" /></svg></a>
                                                            <p class="text-sm">DOI</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-y-6 text-gray-700 mt-6">
                                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <h4 class="font-semibold text-orange-600 text-lg">Mini Review</h4>
                                                            <div class="flex items-center space-x-4 text-gray-600">
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 27</span>
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 6</span>
                                                            </div>
                                                        </div>
                                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Noriko Kubota*</p>

                                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2026/01/jcm-524.pdf" target="_blank">Clinical and Functional Characteristics in ERM, MPH, ERM-FS, and LMH</a></h4>
                                                        <div class="mt-2 flex items-center space-x-2">
                                                            <a href="https://probejournals.com/wp-content/uploads/2026/01/jcm-524.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75-.788888888888889z" clip-rule="evenodd" /></svg></a>
                                                            <p class="text-sm">DOI</p>
                                                        </div>
                                                    </div>
                                                </div>
                                      
                                                <div class="space-y-6 text-gray-700 mt-6">
                                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <h4 class="font-semibold text-orange-600 text-lg">Mini Review</h4>
                                                            <div class="flex items-center space-x-4 text-gray-600">
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 27</span>
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 6</span>
                                                            </div>
                                                        </div>
                                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Stephen D. Kette</p>

                                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/12/JCM-5-19.pdf" target="_blank">Susceptibility to Aluminium Intoxication, the Male Gender Bias in
Autism, and Implications for Vaccine Risk Screening</a></h4>
                                                        <div class="mt-2 flex items-center space-x-2">
                                                            <a href="https://probejournals.com/wp-content/uploads/2025/12/JCM-5-19.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                                            <p class="text-sm">DOI</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-y-6 text-gray-700 mt-6">
                                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <h4 class="font-semibold text-orange-600 text-lg">Mini Review</h4>
                                                            <div class="flex items-center space-x-4 text-gray-600">
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 27</span>
                                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 6</span>
                                                            </div>
                                                        </div>
                                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Francesco Giangregorio</p>

                                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2026/03/jcm-5-26_merged.pdf" target="_blank">From Imaging to Prognosis: The prognostic Value of Vascular and Parenchymal Enhancement Patterns in Chronic Liver Disease by Contrast-Enhanced Ultrasound and MRI</a></h4>
                                                        <div class="mt-2 flex items-center space-x-2">
                                                            <a href="https://probejournals.com/wp-content/uploads/2026/03/jcm-5-26_merged.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                                            <p class="text-sm">DOI</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                    <div class="neumorphic rounded-xl overflow-hidden">
                        <div class="p-4 md:p-6 cursor-pointer flex justify-between items-center toggle-volume" data-target="volume-5">
                            <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Volume 4</h2>
                            <svg class="w-6 h-6 transform transition-transform duration-300 arrow-icon text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div id="volume-5" class="collapse-content">
                            <div class="p-4 md:p-6 space-y-4 border-t border-gray-200">
                                <div class="neumorphic p-4 md:p-8 rounded-xl text-center bg-gray-100">
                                    <h3 class="text-xl font-semibold text-gray-900">Issue 2</h3>
                                </div>
                                <div class="space-y-6 text-gray-700 mt-6">
                                    <!-- Review Article -->
                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-orange-600 text-lg">Case Report</h4>
                                            <div class="flex items-center space-x-4 text-gray-600">
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 27</span>
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 6</span>
                                            </div>
                                        </div>
                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Chiung-Chang Liu*, Wei-Cheng Wen, Kuang-Yu Niu</p>
                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-4-2-2-nd-arti.pdf" target="_blank">Rare Presentation of Diffuse Large B-Cell Lymphoma in a Young
Woman with a Newly Found Mediastinal Mass</a></h4>
                                        <div class="mt-2 flex items-center space-x-2">
                                            <a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-4-2-2-nd-arti.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                            <p class="text-sm">DOI</p>
                                        </div>
                                    </div>
                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-orange-600 text-lg">Mini Review</h4>
                                            <div class="flex items-center space-x-4 text-gray-600">
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 27</span>
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 6</span>
                                            </div>
                                        </div>
                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Mohammadreza Saatian1, Masoumeh Roustaei1, Ebrahim Jalili2*, Sara Ataei3, Ali Poormohammadi4, Maryam Farhadian5, Ali
Abdoli1</p>

                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-4-2-1-st-artic.pdf" target="_blank">The Effect of Curcumin in the Recovery of Severe Traumatic
Brain Injury: A Double-Blind Randomized Controlled Trial</a></h4>
                                        <div class="mt-2 flex items-center space-x-2">
                                            <a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-4-2-1-st-artic.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                            <p class="text-sm">DOI</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 md:p-6 space-y-4 border-t border-gray-200">
                                <div class="neumorphic p-4 md:p-8 rounded-xl text-center bg-gray-100">
                                    <h3 class="text-xl font-semibold text-gray-900">Issue 1</h3>
                                </div>
                                <div class="space-y-6 text-gray-700 mt-6">
                                    <!-- Review Article -->
                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-orange-600 text-lg">Case Report</h4>
                                            <div class="flex items-center space-x-4 text-gray-600">
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 27</span>
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 6</span>
                                            </div>
                                        </div>
                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Som Biswas</p>
                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-4-1-2-nd-arti.pdf" target="_blank">Pulmonary Thromboembolism in COVID-19 Pneumonia: A Case
Series and Update</a> </h4>
                                        <div class="mt-2 flex items-center space-x-2">
                                            <a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-4-1-2-nd-arti.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                            <p class="text-sm">DOI</p>
                                        </div>
                                    </div>
                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-orange-600 text-lg">Research Article</h4>
                                            <div class="flex items-center space-x-4 text-gray-600">
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 27</span>
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 6</span>
                                            </div>
                                        </div>
                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Mohammed Yousuf Iqbal1, Emad A Abdulkarim2, Sarah Albassam3, Fandi Alanazi4</p>

                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-4-1-1-st-arti.pdf" target="_blank">Practice of Extubation in the Emergency Department: A Cross-
Sectional Observational Study</a></h4>
                                        <div class="mt-2 flex items-center space-x-2">
                                            <a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-4-1-1-st-arti.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                            <p class="text-sm">DOI</p>
                                        </div>
                                    </div>
                                    <!-- Volume 5 Section (new) -->
                                   
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Volume 4 Section -->
                    <div class="neumorphic rounded-xl overflow-hidden">
                        <div class="p-4 md:p-6 cursor-pointer flex justify-between items-center toggle-volume" data-target="volume-4">
                            <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Volume 3</h2>
                            <svg class="w-6 h-6 transform transition-transform duration-300 arrow-icon text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div id="volume-4" class="collapse-content">
                            <div class="p-4 md:p-6 space-y-4 border-t border-gray-200">
                                <div class="neumorphic p-4 md:p-8 rounded-xl text-center bg-gray-100">
                                    <h3 class="text-xl font-semibold text-gray-900">Issue 1</h3>
                                </div>
                                <div class="space-y-6 text-gray-700 mt-6">
                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-orange-600 text-lg">Research Article</h4>
                                            <div class="flex items-center space-x-4 text-gray-600">
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 35</span>
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 8</span>
                                            </div>
                                        </div>
                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Hongliang Zhang</p>
                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/11/jcm-3-1-3rd-art.pdf" target="_blank">Effects of Lipoprotein (A) in Aortic Dissection Patients with
Chest Pain and Healthy Groups: A Cross-Sectional Study</a></h4>
                                        <div class="mt-2 flex items-center space-x-2">
                                            <a href="https://probejournals.com/wp-content/uploads/2025/11/jcm-3-1-3rd-art.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                            <p class="text-sm">DOI</p>
                                        </div>
                                    </div>
                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-orange-600 text-lg">Case Report</h4>
                                            <div class="flex items-center space-x-4 text-gray-600">
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 35</span>
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 8</span>
                                            </div>
                                        </div>
                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Adheera Singh</p>
                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/11/jcm-3-1-2nd-art.pdf" target="_blank">Flash Pulmonary Odema-4 Rare Cases of Non-Cardiogenic, Non-
Renal Etiology</a></h4>
                                        <div class="mt-2 flex items-center space-x-2">
                                            <a href="https://probejournals.com/wp-content/uploads/2025/11/jcm-3-1-2nd-art.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                            <p class="text-sm">DOI</p>
                                        </div>
                                    </div>
                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-orange-600 text-lg">Mini Review</h4>
                                            <div class="flex items-center space-x-4 text-gray-600">
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 35</span>
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 8</span>
                                            </div>
                                        </div>
                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Pavan Kumar</p>
                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-31-1-st-arti.pdf" target="_blank">Latest Investigation on Impulsive Respiration and Developing
Phenotypes of Lung Impairment in Patients with SARS-CoV-2</a></h4>
                                        <div class="mt-2 flex items-center space-x-2">
                                            <a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-31-1-st-arti.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                            <p class="text-sm">DOI</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Volume 3 Section -->
                    <div class="neumorphic rounded-xl overflow-hidden">
                        <div class="p-4 md:p-6 cursor-pointer flex justify-between items-center toggle-volume" data-target="volume-3">
                            <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Volume 2</h2>
                            <svg class="w-6 h-6 transform transition-transform duration-300 arrow-icon text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div id="volume-3" class="collapse-content">
                            <div class="p-4 md:p-6 space-y-4 border-t border-gray-200">
                                <div class="neumorphic p-4 md:p-8 rounded-xl text-center bg-gray-100">
                                    <h3 class="text-xl font-semibold text-gray-900">Issue 1</h3>
                                </div>
                                <div class="space-y-6 text-gray-700 mt-6">
                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-orange-600 text-lg">Research Article</h4>
                                            <div class="flex items-center space-x-4 text-gray-600">
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 50</span>
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 15</span>
                                            </div>
                                        </div>
                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Delelegn Emwodew Yehualashet1,*, Atsike Belay Eshetu2, Mentesnote Yemere Zeleke3, Mesfine Sertse Gebremedihn4, Dawit
Girma Mengesha5, Daniel Nigusse Mamo6</p>
                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-21-2nd-artil.pdf" target="_blank">Barriers to the Implementation of Evidence Based Medicine in
Ethiopia: A Systematic Study</a></h4>
                                        <div class="mt-2 flex items-center space-x-2">
                                            <a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-21-2nd-artil.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                            <p class="text-sm">DOI</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-6 text-gray-700 mt-6">
                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-orange-600 text-lg">Mini Review</h4>
                                            <div class="flex items-center space-x-4 text-gray-600">
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 50</span>
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 15</span>
                                            </div>
                                        </div>
                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Subhagata Chattopadhyay</p>
                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-21-1-st-artic.pdf" target="_blank">CT Images of Pyogenic and Amoebic Liver Abscess with K-Means
Clustering: An Application of Image Processing in Medical
Emergency</a></h4>
                                        <div class="mt-2 flex items-center space-x-2">
                                            <a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-21-1-st-artic.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                            <p class="text-sm">DOI</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Volume 3 Section -->
                    <div class="neumorphic rounded-xl overflow-hidden">
                        <div class="p-4 md:p-6 cursor-pointer flex justify-between items-center toggle-volume" data-target="volume-1">
                            <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Volume 1</h2>
                            <svg class="w-6 h-6 transform transition-transform duration-300 arrow-icon text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div id="volume-1" class="collapse-content">
                            <div class="p-4 md:p-6 space-y-4 border-t border-gray-200">
                                <div class="neumorphic p-4 md:p-8 rounded-xl text-center bg-gray-100">
                                    <h3 class="text-xl font-semibold text-gray-900">Issue 1</h3>
                                </div>
                                <div class="space-y-6 text-gray-700 mt-6">
                                    <div class="article-item p-4 rounded-xl border border-gray-200 transition-all hover:bg-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-orange-600 text-lg">Research Article</h4>
                                            <div class="flex items-center space-x-4 text-gray-600">
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> 50</span>
                                                <span class="flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg> 15</span>
                                            </div>
                                        </div>
                                        <p class="text-sm mt-1 text-gray-600">AUTHORS: Akhila R Mandadi1,*, Kathleen Dully2, Jennifer Brailsford3, Todd Wylie1, Thomas K Morrissey1, Phyllis
Hendry1, Shiva Gautam3, Jennifer N Fishe1</p>
                                        <h4 class="font-semibold text-lg text-blue-600 article-link"><a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-1-1.pdf" target="_blank">A National Pediatric Emergency Medicine Perspective on
Improving Education in Child Maltreatment Recognition and
Reporting</a></h4>
                                        <div class="mt-2 flex items-center space-x-2">
                                            <a href="https://probejournals.com/wp-content/uploads/2025/11/JCM-1-1.pdf" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E53E3E" class="w-6 h-6"><path fill-rule="evenodd" d="M19.5 7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v11.25c0 1.24 1.134 2.25 2.536 2.25h10.964c1.402 0 2.536-1.01 2.536-2.25V7.5zM12 9a.75.75 0 01.75.75V12h2.25a.75.75 0 010 1.5h-2.25v2.25a.75.75 0 01-1.5 0v-2.25H9.75a.75.75 0 010-1.5h2.25V9.75A.75.75 0 0112 9z" clip-rule="evenodd" /></svg></a>
                                            <p class="text-sm">DOI</p>
                                        </div>
                                    </div>
                                </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>


        <!-- Content 7: Articles in Press (Reverted to Coming Soon) -->
        <div id="content-articles" class="tab-content hidden neumorphic p-6 rounded-xl shadow-md border-t-4 border-teal-600">
           <div class="container mx-auto px-4 py-8 md:py-16">
        <!-- Main content section with full width -->
        <div class="md:col-span-3 space-y-12">
            <!-- Main Content Section -->
            <div class="neumorphic p-8 rounded-xl">
                <h1 class="text-2xl md:text-4xl lg:text-3xl font-extrabold mb-4 mt-6 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500" style="font-family: 'Lora', serif;">Articles in Press</h1>
                
                <div class="text-center py-20">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900">Coming Soon</h2>
                    <p class="mt-4 text-xl leading-relaxed">This section will contain articles that have been accepted and are awaiting final publication.</p>
                </div>
            </div>
        </div>
    </div>
        </div>

        <!-- Content 8: Contact Us (Updated with clear form simulation) -->
        <div id="content-contact" class="tab-content hidden neumorphic p-6 rounded-xl shadow-md border-t-4 border-pink-600">
            <div class="container mx-auto px-4 py-8 md:py-16">
        <!-- Main content section with full width -->
        <div class="md:col-span-3 space-y-12">
            <!-- Main Content Section -->
            <div class="neumorphic p-8 rounded-xl">
                <h1 class="text-2xl md:text-4xl lg:text-3xl font-extrabold mb-4 mt-6 text-center bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500" style="font-family: 'Lora', serif;">Contact the Editorial Office</h1>
                
                <div class="flex flex-col md:flex-row gap-8 mt-12">
                    <!-- Left side: Contact Info Cards -->
                    <div class="md:w-1/2 space-y-6">
                        <!-- Registered Address Card -->
                        <div class="neumorphic p-6 rounded-xl flex items-start space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 icon-gradient">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 3.868-2.585 6.78-5.632 9.172a1.42 1.42 0 01-1.416 0c-3.047-2.392-5.632-5.304-5.632-9.172A7.5 7.5 0 0112 3a7.5 7.5 0 017.5 7.5z" />
                            </svg>
                            <div>
                                <h3 class="font-bold text-lg mb-2 text-gray-900">Registered Address:</h3>
                                <p class="leading-relaxed">91 Ivy Lane, Waltham Cros, United Kingdom, EN8</p>
                            </div>
                        </div>

                        <!-- Address Card -->
                        <div class="neumorphic p-6 rounded-xl flex items-start space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 icon-gradient">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 3.868-2.585 6.78-5.632 9.172a1.42 1.42 0 01-1.416 0c-3.047-2.392-5.632-5.304-5.632-9.172A7.5 7.5 0 0112 3a7.5 7.5 0 017.5 7.5z" />
                            </svg>
                            <div>
                                <h3 class="font-bold text-lg mb-2 text-gray-900">Address:</h3>
                                <p class="leading-relaxed">3rd Floor, Stanford, Andheri-West, Mumbai, Maharashtra, 400069</p>
                            </div>
                        </div>

                        <!-- Email Card -->
                        <div class="neumorphic p-6 rounded-xl flex items-start space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 icon-gradient">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <div>
                                <h3 class="font-bold text-lg mb-2 text-gray-900">Email:</h3>
                                <p class="leading-relaxed">publish@probejournals.com</p>
                            </div>
                        </div>

                        <!-- Phone Card -->
                        <div class="neumorphic p-6 rounded-xl flex items-start space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 icon-gradient">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.35-1.005-.98-1.12l-1.964-.342a1.725 1.725 0 01-1.033-2.028l.4-1.203a1.725 1.725 0 00-.735-2.196l-2.705-1.913a.75.75 0 00-.594-.145c-.413.084-.814.156-1.215.228-3.921.72-7.143 4.24-7.143 8.358v1.239" />
                            </svg>
                            <div>
                                <h3 class="font-bold text-lg mb-2 text-gray-900">Phone:</h3>
                                <p class="leading-relaxed">+44 3455007136</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right side: Contact Form -->
                    <div class="md:w-1/2 space-y-6">
                        <form id="contact-form" class="p-6 neumorphic rounded-xl space-y-6">
                            <!-- Name Fields -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="name">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <div class="flex space-x-4">
                                    <div class="w-1/2">
                                        <input class="neumorphic-input w-full p-3 text-gray-900 dark:text-gray-100" id="firstName" name="firstName" type="text" placeholder="First" required>
                                    </div>
                                    <div class="w-1/2">
                                        <input class="neumorphic-input w-full p-3 text-gray-900 dark:text-gray-100" id="lastName" name="lastName" type="text" placeholder="Last" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="email">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input class="neumorphic-input w-full p-3 text-gray-900 dark:text-gray-100" id="email" name="email" type="email" placeholder="Your email address" required>
                            </div>

                            <!-- Subject Field -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="subject">
                                    Subject <span class="text-red-500">*</span>
                                </label>
                                <input class="neumorphic-input w-full p-3 text-gray-900 dark:text-gray-100" id="subject" name="subject" type="text" placeholder="Subject of your message" required>
                            </div>

                            <!-- Message Field -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="message">
                                    Comment or Message <span class="text-red-500">*</span>
                                </label>
                                <textarea class="neumorphic-input w-full p-3 text-gray-900 dark:text-gray-100" id="message" name="message" rows="5" placeholder="Your message here..." required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center justify-start">
                                <button class="neumorphic-button font-bold py-3 px-6 rounded-lg focus:outline-none" type="submit">
                                    Send Message
                                </button>
                            </div>
                            <div id="form-message" class="mt-4 text-center text-sm"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </main>

    <!-- JavaScript for Tab, Theme, Archive, and Contact Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const toggleButton = document.getElementById('theme-toggle');
            const moonIcon = document.getElementById('moon-icon');
            const sunIcon = document.getElementById('sun-icon');
            const themeText = document.getElementById('theme-text');
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            const form = document.getElementById('contact-form');
            const messageDiv = document.getElementById('form-message');
            const LAST_TAB_KEY = 'lastTab';

            // --- Theme Switching Logic ---
            const currentTheme = localStorage.getItem('theme');

            /**
             * Applies the chosen theme and updates UI elements.
             * @param {string} theme - 'light' or 'dark'
             */
            const applyTheme = (theme) => {
                if (theme === 'dark') {
                    body.classList.add('dark-mode');
                    moonIcon.classList.add('hidden');
                    sunIcon.classList.remove('hidden');
                    themeText.textContent = 'Light Mode';
                    localStorage.setItem('theme', 'dark');
                } else {
                    body.classList.remove('dark-mode');
                    moonIcon.classList.remove('hidden');
                    sunIcon.classList.add('hidden');
                    themeText.textContent = 'Dark Mode';
                    localStorage.setItem('theme', 'light');
                }
            };

            // Initialize theme on load
            if (currentTheme === 'dark' || (!currentTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                applyTheme('dark');
            } else {
                applyTheme('light');
            }

            // Theme toggle event listener
            toggleButton.addEventListener('click', () => {
                if (body.classList.contains('dark-mode')) {
                    applyTheme('light');
                } else {
                    applyTheme('dark');
                }
            });

            // --- Tab Switching Logic ---
            
            // Function to switch active tab and content
            const switchTab = (tabId) => {
                // Update buttons
                tabButtons.forEach(btn => {
                    if (btn.dataset.tab === tabId) {
                        btn.classList.add('active-tab', 'bg-white/20');
                    } else {
                        btn.classList.remove('active-tab', 'bg-white/20');
                    }
                });

                // Update content visibility
                tabContents.forEach(content => {
                    if (content.id === `content-${tabId}`) {
                        content.classList.remove('hidden');
                    } else {
                        content.classList.add('hidden');
                    }
                });
                
                // Store last active tab in localStorage
                localStorage.setItem(LAST_TAB_KEY, tabId);
            };

            // Add click listeners to all tab buttons
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.dataset.tab;
                    switchTab(tabId);
                });
            });

            // Restore last active tab on page load (default to 'home' if none)
            const savedTab = localStorage.getItem(LAST_TAB_KEY) || 'home';
            switchTab(savedTab);

            // --- Archive Volume Toggle Logic ---
            const volumeToggles = document.querySelectorAll('.toggle-volume');
            
            volumeToggles.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const targetId = toggle.getAttribute('data-target');
                    const content = document.getElementById(targetId);
                    const icon = toggle.querySelector('.arrow-icon');
                    
                    if (content.classList.contains('active')) {
                        content.classList.remove('active');
                        icon.classList.remove('rotate-180');
                    } else {
                        content.classList.add('active');
                        icon.classList.add('rotate-180');
                    }
                });
            });

            // --- Contact Form Submission Logic ---
            if(form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    
                    // Simple simulation of form sending
                    const btn = form.querySelector('button[type="submit"]');
                    const originalText = btn.textContent;
                    
                    btn.textContent = 'Sending...';
                    btn.disabled = true;
                    
                    setTimeout(() => {
                        btn.textContent = originalText;
                        btn.disabled = false;
                        
                        messageDiv.innerHTML = '<span class="text-green-600 dark:text-green-400 font-semibold"><i class="fas fa-check-circle mr-2"></i>Your message has been sent successfully. Our editorial team will contact you shortly.</span>';
                        form.reset();
                        
                        // Clear message after 5 seconds
                        setTimeout(() => {
                            messageDiv.innerHTML = '';
                        }, 5000);
                        
                    }, 1500);
                });
            }
        });
    </script>
</body>
</html>
