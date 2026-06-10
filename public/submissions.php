<?php
require_once __DIR__ . '/../includes/header.php';
$journals = getAllJournals();
$page_title = "Manuscript Submission";
?>

<!-- EmailJS & Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    // Prevent Tailwind from completely resetting the site's existing header/footer styles
    tailwind.config = {
        corePlugins: {
            preflight: false,
        }
    }
</script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

<style>
    .submission-wrapper {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6; /* gray-100 */
        color: #1f2937; /* gray-800 */
        padding: 40px 15px;
        min-height: calc(100vh - 200px);
    }
    /* Styling for the floating label effect */
    .submission-wrapper .floating-label-group {
        position: relative;
    }
    .submission-wrapper .floating-label {
        position: absolute;
        top: 0.85rem; /* Aligned with the input text */
        left: 0;
        pointer-events: none;
        transition: all 0.2s ease-out;
        color: #6b7280;
        background-color: transparent;
        padding: 0 0.1rem;
    }

    /* State when label should float up */
    .submission-wrapper .floating-input:focus ~ .floating-label,
    .submission-wrapper .floating-input:not(:placeholder-shown) ~ .floating-label,
    .submission-wrapper .floating-input.has-value ~ .floating-label,
    .submission-wrapper .file-input.has-file ~ .floating-label {
        top: -0.75rem; /* Position above the input line */
        transform: scale(0.85);
        font-weight: 500;
        color: #2563eb;
        background-color: white;
    }

    /* New bottom-line input style */
    .submission-wrapper .floating-input {
        border: 0;
        border-bottom: 1px solid #d1d5db; /* gray-300 */
        border-radius: 0;
        padding: 0.85rem 0.1rem; /* Adjust padding for bottom line */
        background-color: transparent;
        width: 100%;
        outline: none;
        box-shadow: none;
        transition: border-color 0.2s ease-out;
        font-family: inherit;
        font-size: 1rem;
    }
    
    .submission-wrapper .floating-input:focus {
       border-bottom: 2px solid #2563eb; /* blue-600 */
    }

    /* Custom style for the file input wrapper */
    .submission-wrapper .file-input-wrapper {
        display: block;
        position: relative;
        cursor: pointer;
    }
    .submission-wrapper .file-input {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .submission-wrapper .file-display {
        display: block;
        border-bottom: 1px solid #d1d5db;
        padding: 0.85rem 0.1rem;
        color: #374151; /* gray-700 */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Modal styles */
    .submission-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .submission-modal-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }
    .submission-modal-content {
        background: white;
        padding: 2rem;
        border-radius: 0.5rem;
        max-width: 500px;
        width: 90%;
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }
    .submission-modal-overlay.active .submission-modal-content {
        transform: scale(1);
    }
</style>

<div class="submission-wrapper">
    <div class="container mx-auto max-w-3xl p-4 sm:p-6 lg:p-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-blue-700 m-0">Manuscript Submission</h1>
            <p class="text-lg text-gray-500 mt-2">Submit your article and author details below.</p>
        </div>

        <form id="manuscriptForm" class="bg-white p-8 rounded-xl shadow-2xl space-y-10">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                <!-- Author First Name -->
                <div class="floating-label-group">
                    <input type="text" id="firstName" name="firstName" required placeholder=" " class="floating-input">
                    <label for="firstName" class="floating-label">First Name</label>
                </div>

                <!-- Author Last Name -->
                <div class="floating-label-group">
                    <input type="text" id="lastName" name="lastName" required placeholder=" " class="floating-input">
                    <label for="lastName" class="floating-label">Last Name</label>
                </div>
            
                <!-- Author Email -->
                <div class="floating-label-group">
                    <input type="email" id="email" name="email" required placeholder=" " class="floating-input">
                    <label for="email" class="floating-label">Email Address</label>
                </div>

                <!-- Alternative Email -->
                <div class="floating-label-group">
                    <input type="email" id="altEmail" name="altEmail" placeholder=" " class="floating-input">
                    <label for="altEmail" class="floating-label">Alternative Email</label>
                </div>
            
                <!-- Phone Number -->
                <div class="floating-label-group">
                    <input type="tel" id="phone" name="phone" required placeholder=" " class="floating-input">
                    <label for="phone" class="floating-label">Phone Number</label>
                </div>
                
                <!-- Region Dropdown -->
                <div class="floating-label-group">
                    <select id="region" name="region" required class="floating-input bg-white">
                        <option value="" disabled selected></option>
                        <!-- Country list generated by JS -->
                    </select>
                    <label for="region" class="floating-label">Choose your region</label>
                </div>
            </div>

            <!-- Select Journal -->
            <div class="floating-label-group">
                <select id="targetJournal" name="targetJournal" required class="floating-input bg-white">
                    <option value="" disabled selected></option>
                    <?php foreach($journals as $j): ?>
                        <option value="<?php echo sanitize($j['name']); ?>"><?php echo sanitize($j['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="targetJournal" class="floating-label">Select Target Journal</label>
            </div>

            <!-- Title -->
            <div class="floating-label-group">
                <input type="text" id="title" name="title" required placeholder=" " class="floating-input">
                <label for="title" class="floating-label">Title of Manuscript</label>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                <!-- Article Type Dropdown -->
                <div class="floating-label-group">
                    <select id="articleType" name="articleType" required class="floating-input bg-white">
                        <option value="" disabled selected></option>
                        <option>Announcement</option>
                        <option>Book Reviews</option>
                        <option>Case Report</option>
                        <option>Clinical Image</option>
                        <option>Commentary Article</option>
                        <option>Conference Proceedings</option>
                        <option>Editorial</option>
                        <option>Expert Reviews</option>
                        <option>General Commentaries</option>
                        <option>Hyper Thesis</option>
                        <option>Image Article</option>
                        <option>Letter</option>
                        <option>Method</option>
                        <option>Mini Review</option>
                        <option>Opinion</option>
                        <option>Perspective</option>
                    </select>
                    <label for="articleType" class="floating-label">Select Article Type</label>
                </div>
                
                <!-- Issue Type Dropdown -->
                <div class="floating-label-group">
                    <select id="issueType" name="issueType" required class="floating-input bg-white">
                        <option value="" disabled selected></option>
                        <option>Regular Issue</option>
                        <option>Special Issue</option>
                    </select>
                    <label for="issueType" class="floating-label">Issue Type</label>
                </div>
            </div>

            <!-- Special Issue Title (Conditional) -->
            <div id="specialIssueTitleGroup" class="floating-label-group hidden">
                <input type="text" id="specialIssueTitle" name="specialIssueTitle" placeholder=" " class="floating-input">
                <label for="specialIssueTitle" class="floating-label">Special Issue Title</label>
            </div>
            
            <!-- File Attachment Field -->
            <div class="floating-label-group pt-4">
                <div class="file-input-wrapper">
                    <input type="file" id="manuscriptFile" name="manuscriptFile" class="file-input" accept=".pdf,.doc,.docx" required>
                    <label for="manuscriptFile" class="floating-label" style="background: white;">Attach Article (PDF, DOC/DOCX)</label>
                    <span id="fileDisplay" class="file-display">No file selected</span>
                </div>
                <div id="fileStatus" class="text-sm mt-2 font-medium"></div>
            </div>

            <!-- Comment or Message -->
            <div class="floating-label-group">
                <textarea id="message" name="message" rows="4" required placeholder=" " class="floating-input"></textarea>
                <label for="message" class="floating-label" style="background: white;">Comment or Message</label>
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-center pt-4">
                <button type="submit" id="submitBtn" class="inline-flex items-center justify-center px-10 py-3 border border-transparent text-base font-medium rounded-xl shadow-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:scale-[1.02]">
                    <svg id="submitSpinner" class="hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span>Submit Manuscript</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Success/Error Modal -->
<div id="statusModal" class="submission-modal-overlay">
    <div class="submission-modal-content text-center">
        <div id="modalIcon"></div>
        <h3 id="modalTitle" class="text-2xl font-bold mt-4 mb-2"></h3>
        <p id="modalMessage" class="text-gray-600"></p>
        <button id="closeModalBtn" class="mt-6 w-full px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">Close</button>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // Configuration & Constants
        const EMAILJS_SERVICE_ID = 'service_sbpu45d';
        const EMAILJS_ADMIN_TEMPLATE_ID = 'template_9emiqcp'; 
        const EMAILJS_USER_TEMPLATE_ID = 'template_2xpdc6e';  
        const EMAILJS_PUBLIC_KEY = 'werRTUtIjNueL4yRk';
        const MAX_FILE_SIZE_BYTES = 5 * 1024 * 1024; // 5MB limit for Base64 attachment

        emailjs.init(EMAILJS_PUBLIC_KEY);

        // DOM Elements
        const manuscriptForm = document.getElementById('manuscriptForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = submitBtn.querySelector('span');
        const submitSpinner = document.getElementById('submitSpinner');
        const statusModal = document.getElementById('statusModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const regionSelect = document.getElementById('region');
        const issueTypeSelect = document.getElementById('issueType');
        const specialIssueGroup = document.getElementById('specialIssueTitleGroup');
        const manuscriptFileInput = document.getElementById('manuscriptFile');
        const fileDisplay = document.getElementById('fileDisplay');
        const fileStatus = document.getElementById('fileStatus');

        // Global State for Attachment
        let attachmentData = {
            base64: null,
            filename: null,
            valid: false
        };
        
        // --- UTILITY FUNCTIONS ---

        const showModal = (type, title, message) => {
            const modalIcon = document.getElementById('modalIcon');
            if (type === 'success') {
                modalIcon.innerHTML = `<svg class="mx-auto h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;
            } else {
                 modalIcon.innerHTML = `<svg class="mx-auto h-16 w-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;
            }
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            statusModal.classList.add('active');
        };
        
        // Convert file to Base64 string
        const fileToBase64 = (file) => {
            return new Promise((resolve, reject) => {
                if (file.size > MAX_FILE_SIZE_BYTES) {
                    return reject(new Error('File is too large. Maximum size is 5MB.'));
                }
                
                const reader = new FileReader();
                reader.onloadend = () => {
                    const base64String = reader.result.split(',')[1]; 
                    resolve(base64String);
                };
                reader.onerror = (error) => reject(error);
                reader.readAsDataURL(file);
            });
        };

        const updateSubmissionButton = (isLoading) => {
            if (isLoading) {
                submitBtn.disabled = true;
                submitText.textContent = 'Submitting...';
                submitSpinner.classList.remove('hidden');
            } else {
                submitBtn.disabled = false;
                submitText.textContent = 'Submit Manuscript';
                submitSpinner.classList.add('hidden');
            }
        };

        // --- UI LOGIC ---

        const countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Central African Republic","Chad","Chile","China","Colombia","Comoros","Congo, Democratic Republic of the","Congo, Republic of the","Costa Rica","Cote d'Ivoire","Croatia","Cuba","Cyprus","Czechia","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini","Ethiopia","Fiji","Finland","France","Gabon","Gambia","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Morocco","Mozambique","Myanmar (Burma)","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","North Korea","North Macedonia","Norway","Oman","Pakistan","Palau","Palestine State","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","Sudan","Suriname","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City (Holy See)","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"];
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country;
            option.textContent = country;
            regionSelect.appendChild(option);
        });
        
        const selects = document.querySelectorAll('select.floating-input');
        selects.forEach(select => {
            select.addEventListener('change', (e) => {
                if (e.target.value) {
                    e.target.classList.add('has-value');
                } else {
                    e.target.classList.remove('has-value');
                }
            });
        });

        issueTypeSelect.addEventListener('change', function () {
            if (this.value === 'Special Issue') {
                specialIssueGroup.classList.remove('hidden');
                document.getElementById('specialIssueTitle').setAttribute('required', 'required');
            } else {
                specialIssueGroup.classList.add('hidden');
                document.getElementById('specialIssueTitle').removeAttribute('required');
            }
        });
        
        closeModalBtn.addEventListener('click', () => statusModal.classList.remove('active'));
        statusModal.addEventListener('click', (e) => {
            if(e.target === statusModal) statusModal.classList.remove('active');
        });

        // --- FILE INPUT LOGIC ---
        manuscriptFileInput.addEventListener('change', async function() {
            const file = this.files[0];
            fileStatus.textContent = '';
            fileStatus.classList.remove('text-green-600', 'text-red-600');
            
            if (!file) {
                fileDisplay.textContent = 'No file selected';
                fileDisplay.classList.remove('has-file');
                attachmentData = { base64: null, filename: null, valid: false };
                return;
            }

            fileDisplay.textContent = file.name;
            fileDisplay.classList.add('has-file');
            
            fileStatus.textContent = 'Reading file...';
            fileStatus.classList.add('text-blue-600');

            try {
                const base64Content = await fileToBase64(file);
                attachmentData = { 
                    base64: base64Content,
                    filename: file.name,
                    valid: true
                };
                
                fileStatus.textContent = `File loaded successfully (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                fileStatus.classList.remove('text-blue-600');
                fileStatus.classList.add('text-green-600');

            } catch (error) {
                console.error('File reading failed:', error);
                fileStatus.textContent = error.message;
                fileStatus.classList.remove('text-blue-600');
                fileStatus.classList.add('text-red-600');
                attachmentData = { base64: null, filename: null, valid: false };
            }
        });

        // --- FORM SUBMISSION LOGIC ---
        manuscriptForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            
            if (!attachmentData.valid || !attachmentData.base64) {
                showModal('error', 'Attachment Required', 'Please attach a valid manuscript file (PDF or DOC/DOCX) under 5MB.');
                return;
            }

            updateSubmissionButton(true);

            const formData = new FormData(this);
            const templateParams = {
                firstName: formData.get('firstName'),
                lastName: formData.get('lastName'),
                email: formData.get('email'),
                altEmail: formData.get('altEmail'),
                phone: formData.get('phone'),
                region: formData.get('region'),
                targetJournal: formData.get('targetJournal'),
                title: formData.get('title'),
                articleType: formData.get('articleType'),
                issueType: formData.get('issueType'),
                specialIssueTitle: formData.get('specialIssueTitle') || 'N/A',
                message: formData.get('message'),
                reply_to: formData.get('email'), 
                
                file_name: attachmentData.filename,
                file_base64: attachmentData.base64
            };

            try {
                const sendAdminEmail = emailjs.send(EMAILJS_SERVICE_ID, EMAILJS_ADMIN_TEMPLATE_ID, templateParams);
                const sendUserEmail = emailjs.send(EMAILJS_SERVICE_ID, EMAILJS_USER_TEMPLATE_ID, {
                    to_name: templateParams.firstName,
                    to_email: templateParams.email,
                    email: templateParams.email,
                    title: templateParams.title,
                    reply_to: templateParams.email,
                });

                await Promise.all([sendAdminEmail, sendUserEmail]);
                
                showModal('success', 'Submission Successful!', 'Thank you for your manuscript submission. A confirmation email has been sent to your address.');
                manuscriptForm.reset();
                
                selects.forEach(select => select.classList.remove('has-value'));
                specialIssueGroup.classList.add('hidden');
                fileDisplay.textContent = 'No file selected';
                fileDisplay.classList.remove('has-file');
                fileStatus.textContent = '';
                attachmentData = { base64: null, filename: null, valid: false };

            } catch (err) {
                 showModal('error', 'Submission Failed', 'Something went wrong during submission. Please check your network or try again later. Error: ' + JSON.stringify(err));
            } finally {
                updateSubmissionButton(false);
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
