<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create an Account | Legals Forum</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-primary: #040814;
            --bg-glow: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 60%);
            --card-bg: rgba(13, 20, 38, 0.75);
            --border-color: rgba(255, 255, 255, 0.08);
            --accent-color: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.3);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --danger-color: #ef4444;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        html {
            overflow-x: hidden;
            overflow-y: auto;
        }

        body {
            background-color: var(--bg-primary);
            background-image: var(--bg-glow);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 60px 20px;
            position: relative;
        }

        /* Ambient background blobs */
        .ambient-blob-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 40vw;
            height: 40vw;
            background: rgba(59, 130, 246, 0.08);
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: float 20s ease-in-out infinite alternate;
            will-change: transform;
            transform: translate3d(0, 0, 0);
        }

        .ambient-blob-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 40vw;
            height: 40vw;
            background: rgba(236, 72, 153, 0.05);
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: float 25s ease-in-out infinite alternate-reverse;
            will-change: transform;
            transform: translate3d(0, 0, 0);
        }

        @keyframes float {
            0% { transform: translate3d(0, 0, 0) scale(1); }
            100% { transform: translate3d(50px, 50px, 0) scale(1.1); }
        }

        /* Glassmorphism Auth Container */
        .auth-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            z-index: 10;
            position: relative;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Logo Area */
        .brand-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: var(--accent-gradient);
            box-shadow: 0 8px 24px var(--accent-glow);
            margin-bottom: 16px;
            color: #fff;
            font-size: 22px;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff;
            margin-bottom: 6px;
        }

        .brand-tagline {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Form Layout Grid */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 500px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Form Group Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            transition: var(--transition-smooth);
            font-size: 15px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px 12px 48px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            font-size: 14px;
            outline: none;
            transition: var(--transition-smooth);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px var(--accent-glow);
            background: rgba(255, 255, 255, 0.06);
        }

        .form-control:focus + .input-icon {
            color: var(--accent-color);
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
            background-repeat: no-repeat;
            background-position: right 12px center;
            cursor: pointer;
        }

        select.form-control option {
            background-color: #0b0f19;
            color: var(--text-primary);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--accent-gradient);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 24px var(--accent-glow);
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px var(--accent-glow);
        }

        /* Footer links */
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .auth-footer a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition-smooth);
        }

        .auth-footer a:hover {
            color: #60a5fa;
            text-decoration: underline;
        }

        /* Error States */
        .error-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .error-icon {
            color: var(--danger-color);
            font-size: 18px;
            margin-top: 2px;
        }

        .error-message {
            font-size: 13px;
            color: #fca5a5;
            font-weight: 500;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <div style="position: absolute; inset: 0; overflow: hidden; pointer-events: none; z-index: 0;">
        <div class="ambient-blob-1"></div>
        <div class="ambient-blob-2"></div>
    </div>

    <div class="auth-container">
        <!-- Logo Area -->
        <div class="brand-header">
            <a href="/" style="text-decoration: none; color: inherit; display: inline-block; cursor: pointer;">
                <div class="brand-logo">
                    <i class="fa fa-balance-scale"></i>
                </div>
            </a>
            <h1 class="brand-name">Create an Account</h1>
            <p class="brand-tagline">Join Legals Forum to download legal books & search case laws</p>
        </div>

        <!-- Error Alerts -->
        @if ($errors->any())
            <div class="error-alert">
                <i class="fa-solid fa-circle-exclamation error-icon"></i>
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-grid">
                <!-- First Name -->
                <div class="form-group">
                    <label for="name" class="form-label">First Name</label>
                    <div class="input-wrapper">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="John" required autocomplete="name" autofocus>
                        <i class="fa-solid fa-user input-icon"></i>
                    </div>
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label for="lname" class="form-label">Last Name</label>
                    <div class="input-wrapper">
                        <input id="lname" type="text" class="form-control" name="lname" value="{{ old('lname') }}" placeholder="Doe" required autocomplete="lname">
                        <i class="fa-solid fa-user-tag input-icon"></i>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="form-group full-width">
                    <label for="email" class="form-label">E-Mail Address</label>
                    <div class="input-wrapper">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="john.doe@example.com" required autocomplete="email">
                        <i class="fa-solid fa-envelope input-icon"></i>
                    </div>
                </div>

                <!-- Country -->
                <div class="form-group">
                    <label for="country" class="form-label">Country</label>
                    <div class="input-wrapper">
                        <select class="form-control" id="country" name="country">
                            <option value="Afganistan">Afghanistan</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bonaire">Bonaire</option>
                            <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                            <option value="Brunei">Brunei</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Canary Islands">Canary Islands</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Channel Islands">Channel Islands</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos Island">Cocos Island</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote DIvoire">Cote DIvoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Curaco">Curacao</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="East Timor">East Timor</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands">Falkland Islands</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Ter">French Southern Ter</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana" selected>Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Great Britain">Great Britain</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Hawaii">Hawaii</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="India">India</option>
                            <option value="Iran">Iran</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Isle of Man">Isle of Man</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea North">Korea North</option>
                            <option value="Korea Sout">Korea South</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Laos">Laos</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libya">Libya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macau">Macau</option>
                            <option value="Macedonia">Macedonia</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Midway Islands">Midway Islands</option>
                            <option value="Moldova">Moldova</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Nambia">Nambia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherland Antilles">Netherland Antilles</option>
                            <option value="Netherlands">Netherlands (Holland, Europe)</option>
                            <option value="Nevis">Nevis</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau Island">Palau Island</option>
                            <option value="Palestine">Palestine</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Phillipines">Philippines</option>
                            <option value="Pitcairn Island">Pitcairn Island</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Republic of Montenegro">Republic of Montenegro</option>
                            <option value="Republic of Serbia">Republic of Serbia</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russia">Russia</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="St Barthelemy">St Barthelemy</option>
                            <option value="St Eustatius">St Eustatius</option>
                            <option value="St Helena">St Helena</option>
                            <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                            <option value="St Lucia">St Lucia</option>
                            <option value="St Maarten">St Maarten</option>
                            <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                            <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                            <option value="Saipan">Saipan</option>
                            <option value="Samoa">Samoa</option>
                            <option value="Samoa American">Samoa American</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syria">Syria</option>
                            <option value="Tahiti">Tahiti</option>
                            <option value="Taiwan">Taiwan</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania">Tanzania</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Erimates">United Arab Emirates</option>
                            <option value="United States of America">United States of America</option>
                            <option value="Uraguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Vatican City State">Vatican City State</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Vietnam">Vietnam</option>
                            <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                            <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                            <option value="Wake Island">Wake Island</option>
                            <option value="Wallis & Futana Is">Wake Island</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zaire">Zaire</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>
                        </select>
                        <i class="fa-solid fa-earth-americas input-icon"></i>
                    </div>
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <div class="input-wrapper">
                        <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="+233 24 000 0000" required>
                        <i class="fa-solid fa-phone input-icon"></i>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input id="password" type="password" class="form-control" name="password" placeholder="••••••••" required autocomplete="new-password" style="padding-right: 48px;">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <i class="fa-solid fa-eye toggle-password" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary); transition: var(--transition-smooth);" onclick="togglePasswordVisibility('password', this)"></i>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password-confirm" class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" style="padding-right: 48px;">
                        <i class="fa-solid fa-circle-check input-icon"></i>
                        <i class="fa-solid fa-eye toggle-password" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary); transition: var(--transition-smooth);" onclick="togglePasswordVisibility('password-confirm', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                <span>Create Account</span>
                <i class="fa-solid fa-user-plus"></i>
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}">Sign In</a>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId, icon) {
            const passwordField = document.getElementById(fieldId);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.getElementById('country');
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');
            const registerForm = document.querySelector('form');
            const submitBtn = document.querySelector('.btn-submit');

            let emailTimeout = null;
            let phoneTimeout = null;
            let emailValid = true;
            let phoneValid = true;

            function setInputError(inputElement, errorMessage) {
                // Clear any existing error first
                clearInputError(inputElement);

                inputElement.style.borderColor = '#ef4444';
                inputElement.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.15)';
                
                const wrapper = inputElement.parentElement;
                const icon = wrapper.querySelector('.input-icon');
                if (icon) {
                    icon.style.color = '#ef4444';
                }

                const errorDiv = document.createElement('div');
                errorDiv.className = 'ajax-error-msg';
                errorDiv.style.color = '#ef4444';
                errorDiv.style.fontSize = '12px';
                errorDiv.style.marginTop = '6px';
                errorDiv.style.fontWeight = '500';
                errorDiv.style.display = 'flex';
                errorDiv.style.alignItems = 'center';
                errorDiv.style.gap = '6px';
                errorDiv.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i> ${errorMessage}`;
                
                // Insert after wrapper
                wrapper.parentElement.appendChild(errorDiv);
            }

            function clearInputError(inputElement) {
                inputElement.style.borderColor = '';
                inputElement.style.boxShadow = '';
                
                const wrapper = inputElement.parentElement;
                const icon = wrapper.querySelector('.input-icon');
                if (icon) {
                    icon.style.color = '';
                }

                const parent = wrapper.parentElement;
                const existingError = parent.querySelector('.ajax-error-msg');
                if (existingError) {
                    existingError.remove();
                }
            }

            function updateSubmitBtnState() {
                if (submitBtn) {
                    if (!emailValid || !phoneValid) {
                        submitBtn.disabled = true;
                        submitBtn.style.opacity = '0.5';
                        submitBtn.style.cursor = 'not-allowed';
                    } else {
                        submitBtn.disabled = false;
                        submitBtn.style.opacity = '';
                        submitBtn.style.cursor = '';
                    }
                }
            }

            function checkEmail(emailValue) {
                if (!emailValue) {
                    setInputError(emailInput, 'Email address is required.');
                    emailValid = false;
                    updateSubmitBtnState();
                    return;
                }

                // Simple regex pre-check
                if (!emailValue.includes('@') || !emailValue.includes('.')) {
                    clearInputError(emailInput);
                    emailValid = true;
                    updateSubmitBtnState();
                    return;
                }

                fetch(`/register/check-duplicate?email=${encodeURIComponent(emailValue)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.email_taken) {
                            setInputError(emailInput, 'This email address is already registered.');
                            emailValid = false;
                        } else {
                            clearInputError(emailInput);
                            emailValid = true;
                        }
                        updateSubmitBtnState();
                    })
                    .catch(err => console.error('Error checking email:', err));
            }

            function checkPhone(phoneValue, skipEmptyError = false) {
                if (!phoneValue) {
                    if (!skipEmptyError) {
                        setInputError(phoneInput, 'Phone number is required.');
                    } else {
                        clearInputError(phoneInput);
                    }
                    phoneValid = false;
                    updateSubmitBtnState();
                    return;
                }

                // For Ghana, only check duplicate if length is exactly 10 digits
                if (countrySelect && countrySelect.value === 'Ghana' && phoneValue.length !== 10) {
                    clearInputError(phoneInput);
                    phoneValid = true;
                    updateSubmitBtnState();
                    return;
                }

                fetch(`/register/check-duplicate?phone=${encodeURIComponent(phoneValue)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.phone_taken) {
                            setInputError(phoneInput, 'This phone number is already registered.');
                            phoneValid = false;
                        } else {
                            clearInputError(phoneInput);
                            phoneValid = true;
                        }
                        updateSubmitBtnState();
                    })
                    .catch(err => console.error('Error checking phone:', err));
            }

            const countryPlaceholders = {
                "Afghanistan": "+93 70 000 0000",
                "Albania": "+355 67 000 0000",
                "Algeria": "+213 50 000 0000",
                "American Samoa": "+1 684 000 0000",
                "Andorra": "+376 300 000",
                "Angola": "+244 910 000 000",
                "Anguilla": "+1 264 497 0000",
                "Antigua & Barbuda": "+1 268 460 0000",
                "Argentina": "+54 9 11 0000 0000",
                "Armenia": "+374 90 000000",
                "Aruba": "+297 590 0000",
                "Australia": "+61 400 123 456",
                "Austria": "+43 660 0000000",
                "Azerbaijan": "+994 50 000 00 00",
                "Bahamas": "+1 242 300 0000",
                "Bahrain": "+973 3000 0000",
                "Bangladesh": "+880 1700 000000",
                "Barbados": "+1 246 400 0000",
                "Belarus": "+375 29 000 00 00",
                "Belgium": "+32 470 00 00 00",
                "Belize": "+501 600 0000",
                "Benin": "+229 90 000 000",
                "Bermuda": "+1 441 300 0000",
                "Bhutan": "+975 17 000 000",
                "Bolivia": "+591 700 00000",
                "Bonaire": "+599 700 0000",
                "Bosnia & Herzegovina": "+387 61 000 000",
                "Botswana": "+267 71 000 000",
                "Brazil": "+55 11 90000-0000",
                "Brunei": "+673 800 0000",
                "Bulgaria": "+359 87 000 0000",
                "Burkina Faso": "+226 70 00 00 00",
                "Burundi": "+257 71 00 00 00",
                "Cambodia": "+855 12 000 000",
                "Cameroon": "+237 600 000 000",
                "Canada": "+1 416 000 0000",
                "Cape Verde": "+238 900 00 00",
                "Cayman Islands": "+1 345 949 0000",
                "Central African Republic": "+236 70 00 00 00",
                "Chad": "+235 60 00 00 00",
                "Chile": "+56 9 0000 0000",
                "China": "+86 139 0000 0000",
                "Colombia": "+57 300 000 0000",
                "Comoros": "+269 320 00 00",
                "Congo": "+242 05 000 00 00",
                "Cook Islands": "+682 50 000",
                "Costa Rica": "+506 8000 0000",
                "Cote DIvoire": "+225 05 00 00 00",
                "Croatia": "+385 91 000 0000",
                "Cuba": "+53 5 000 0000",
                "Curaco": "+599 9 500 0000",
                "Cyprus": "+357 99 000000",
                "Czech Republic": "+420 700 000 000",
                "Denmark": "+45 20 00 00 00",
                "Djibouti": "+253 77 00 00 00",
                "Dominica": "+1 767 200 0000",
                "Dominican Republic": "+1 809 200 0000",
                "East Timor": "+670 770 0000",
                "Ecuador": "+593 90 000 0000",
                "Egypt": "+20 100 000 0000",
                "El Salvador": "+503 7000 0000",
                "Equatorial Guinea": "+240 222 000 000",
                "Eritrea": "+291 7 00 00 00",
                "Estonia": "+372 5000 0000",
                "Ethiopia": "+251 90 000 0000",
                "Falkland Islands": "+500 50000",
                "Faroe Islands": "+298 500000",
                "Fiji": "+679 900 0000",
                "Finland": "+358 40 0000000",
                "France": "+33 6 00 00 00 00",
                "French Guiana": "+594 694 00 00 00",
                "French Polynesia": "+689 87 00 00 00",
                "Gabon": "+241 06 00 00 00",
                "Gambia": "+220 700 0000",
                "Georgia": "+995 500 00 00 00",
                "Germany": "+49 150 00000000",
                "Gibraltar": "+350 50000000",
                "Greece": "+30 690 000 0000",
                "Greenland": "+299 50 00 00",
                "Grenada": "+1 473 400 0000",
                "Guadeloupe": "+590 690 00 00 00",
                "Guam": "+1 671 400 0000",
                "Guatemala": "+502 5000 0000",
                "Guinea": "+224 600 00 00 00",
                "Guyana": "+592 600 0000",
                "Haiti": "+509 30 00 0000",
                "Hawaii": "+1 808 000 0000",
                "Honduras": "+504 9000-0000",
                "Hong Kong": "+852 9000 0000",
                "Hungary": "+36 20 000 0000",
                "Iceland": "+354 800 0000",
                "India": "+91 90000 00000",
                "Indonesia": "+62 812-3456-7890",
                "Iran": "+98 900 000 0000",
                "Iraq": "+964 700 000 0000",
                "Ireland": "+353 80 000 0000",
                "Israel": "+972 50-000-0000",
                "Italy": "+39 300 000 0000",
                "Jamaica": "+1 876 900 0000",
                "Japan": "+81 90-0000-0000",
                "Jordan": "+962 7 9000 0000",
                "Kazakhstan": "+7 700 000 0000",
                "Kenya": "+254 700 000000",
                "Kuwait": "+965 9000 0000",
                "Kyrgyzstan": "+996 500 000 000",
                "Laos": "+856 20 50 000 000",
                "Latvia": "+371 20 000 000",
                "Lebanon": "+961 70 000 000",
                "Lesotho": "+266 50 000 000",
                "Liberia": "+231 77 000 000",
                "Libya": "+218 90 000 0000",
                "Liechtenstein": "+423 700 00 00",
                "Lithuania": "+370 600 00000",
                "Luxembourg": "+352 691 000 000",
                "Macau": "+853 6000 0000",
                "Macedonia": "+389 70 000 000",
                "Madagascar": "+261 32 00 000 00",
                "Malaysia": "+60 10-000 0000",
                "Malawi": "+265 99 000 0000",
                "Maldives": "+960 700-0000",
                "Mali": "+223 70 00 00 00",
                "Malta": "+356 9900 0000",
                "Marshall Islands": "+692 400 0000",
                "Mauritania": "+222 40 00 00 00",
                "Mauritius": "+230 500 0000",
                "Mexico": "+52 55 0000 0000",
                "Moldova": "+373 60 000000",
                "Monaco": "+377 6 00 00 00 00",
                "Mongolia": "+976 9000 0000",
                "Montserrat": "+1 664 491 0000",
                "Morocco": "+212 600-000000",
                "Mozambique": "+258 80 000 0000",
                "Myanmar": "+95 9 0000 0000",
                "Nambia": "+264 81 000 0000",
                "Nauru": "+674 555 0000",
                "Nepal": "+977 980-0000000",
                "Netherlands": "+31 6 00000000",
                "New Caledonia": "+687 70.00.00",
                "New Zealand": "+64 20 000 0000",
                "Nicaragua": "+505 8000 0000",
                "Niger": "+227 90 00 00 00",
                "Nigeria": "+234 803 000 0000",
                "Norway": "+47 900 00 000",
                "Oman": "+968 9000 0000",
                "Pakistan": "+92 300 0000000",
                "Palestine": "+970 59 000 0000",
                "Panama": "+507 6000-0000",
                "Papua New Guinea": "+675 7000 0000",
                "Paraguay": "+595 981 000 000",
                "Peru": "+51 900 000 00",
                "Phillipines": "+63 900 000 0000",
                "Poland": "+48 500 000 000",
                "Portugal": "+351 900 000 000",
                "Puerto Rico": "+1 787 000 0000",
                "Qatar": "+974 5000 0000",
                "Romania": "+40 700 000 000",
                "Russia": "+7 900 000-00-00",
                "Rwanda": "+250 780 000 000",
                "Saudi Arabia": "+966 50 000 0000",
                "Senegal": "+221 77 000 00 00",
                "Seychelles": "+248 2 000 000",
                "Sierra Leone": "+232 70 000000",
                "Singapore": "+65 9000 0000",
                "Slovakia": "+421 900 000 000",
                "Slovenia": "+386 40 000 000",
                "Solomon Islands": "+677 70 00000",
                "Somalia": "+252 90 000000",
                "South Africa": "+27 82 000 0000",
                "Spain": "+34 600 000 000",
                "Sri Lanka": "+94 70 000 0000",
                "Sudan": "+249 90 000 0000",
                "Suriname": "+597 800-0000",
                "Sweden": "+46 70 000 00 00",
                "Switzerland": "+41 78 000 00 00",
                "Syria": "+963 90 000 0000",
                "Taiwan": "+886 900 000 000",
                "Tanzania": "+255 700 000 000",
                "Thailand": "+66 80 000 0000",
                "Togo": "+228 90 00 00 00",
                "Tonga": "+676 70 000",
                "Trinidad & Tobago": "+1 868 400 0000",
                "Tunisia": "+216 90 000 000",
                "Turkey": "+90 500 000 00 00",
                "Uganda": "+256 700 000000",
                "Ukraine": "+380 50 000 0000",
                "United Arab Erimates": "+971 50 000 0000",
                "United Kingdom": "+44 7911 123456",
                "United States of America": "+1 202-555-0199",
                "Uraguay": "+598 90 000 000",
                "Uzbekistan": "+998 90 000 00 00",
                "Venezuela": "+58 412 000 0000",
                "Vietnam": "+84 90 000 0000",
                "Yemen": "+967 70 000 000",
                "Zambia": "+260 95 0000000",
                "Zimbabwe": "+263 77 000 0000"
            };

            if (countrySelect && phoneInput) {
                function updatePhoneConstraints() {
                    const selectedCountry = countrySelect.value;
                    if (selectedCountry === 'Ghana') {
                        phoneInput.placeholder = '0240000000';
                        phoneInput.maxLength = 10;
                        // Strip non-digits and limit to 10
                        phoneInput.value = phoneInput.value.replace(/\D/g, '').slice(0, 10);
                    } else {
                        const placeholder = countryPlaceholders[selectedCountry] || '+1 555 000 0000';
                        phoneInput.placeholder = placeholder;
                        phoneInput.removeAttribute('maxLength');
                    }
                    // Run duplicate check again since input value changes
                    checkPhone(phoneInput.value.trim(), true);
                }

                // Run on page load
                updatePhoneConstraints();

                // Run on country change
                countrySelect.addEventListener('change', updatePhoneConstraints);

                // Filter non-digits and enforce limit for Ghana
                phoneInput.addEventListener('input', function() {
                    if (countrySelect.value === 'Ghana') {
                        this.value = this.value.replace(/\D/g, '');
                        if (this.value.length > 10) {
                            this.value = this.value.slice(0, 10);
                        }
                    }
                    
                    clearTimeout(phoneTimeout);
                    phoneTimeout = setTimeout(() => {
                        checkPhone(this.value.trim());
                    }, 400);
                });

                phoneInput.addEventListener('blur', function() {
                    clearTimeout(phoneTimeout);
                    checkPhone(this.value.trim());
                });
            }

            if (emailInput) {
                emailInput.addEventListener('input', function() {
                    clearTimeout(emailTimeout);
                    emailTimeout = setTimeout(() => {
                        checkEmail(this.value.trim());
                    }, 400);
                });

                emailInput.addEventListener('blur', function() {
                    clearTimeout(emailTimeout);
                    checkEmail(this.value.trim());
                });
            }

            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    if (!emailValid || !phoneValid) {
                        e.preventDefault();
                        alert('Please correct the duplicate registration errors before submitting.');
                    }
                });
            }
        });
    </script>
</body>
</html>
