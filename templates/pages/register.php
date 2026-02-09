<body>
<h1>Login</h1>
<form method="post" class="row g-3 needs-validation" novalidate>
    <div class="col-md-4">
        <label for="first-name" class="form-label">First name</label>
        <input type="text" class="form-control" id="first-name" name="first_name" required>
        <div class="valid-feedback">
            Looks good!
        </div>
    </div>
    <div class="col-md-4">
        <label for="last-name" class="form-label">Last name</label>
        <input type="text" class="form-control" id="last-name" name="last_name" required>
        <div class="valid-feedback">
            Looks good!
        </div>
    </div>
    <div class="col-md-4">
        <label for="email" class="form-label">E-mail</label>
        <div class="input-group has-validation">
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
    </div>
    <div class="col-md-4">
        <label for="password" class="form-label">Password</label>
        <div class="input-group has-validation">
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
    </div>
    <div class="col-md-4">
        <label for="password-retype" class="form-label">Retype password</label>
        <div class="input-group has-validation">
            <input type="password" class="form-control" id="password-retype" name="password_retype" required>
        </div>
    </div>
    <div class="col-md-6">
        <label for="country" class="form-label">Country</label>
        <input type="text" class="form-control" id="country" name="country" required>
        <div class="invalid-feedback">
            Please provide a valid country.
        </div>
    </div>
    <div class="col-md-6">
        <label for="city" class="form-label">City</label>
        <input type="text" class="form-control" id="city" name="city" required>
        <div class="invalid-feedback">
            Please provide a valid city.
        </div>
    </div>
    <div class="col-md-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" required>
        <div class="invalid-feedback">
            Please provide a valid address.
        </div>
    </div>
    <div class="col-md-3">
        <label for="phone-number" class="form-label">Phone number</label>
        <input type="text" class="form-control" id="phone-number" name="phone_number" required>
        <div class="invalid-feedback">
            Please provide a valid address.
        </div>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Submit form</button>
    </div>
</form>
<script>
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
</body>