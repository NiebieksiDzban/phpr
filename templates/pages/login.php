<body>
    <h1>Login</h1>
    <form method="POST" class="row g-3 needs-validation" novalidate>
        <div class="col-1">
            <label for="email" class="input-group has-validation">
                Email
            </label>
            <input type="email" class="form-control" name="email" placeholder="Email" id="email" required>
            <br>
            <label for="password" class="input-group has-validation">
                Password
            </label>
            <input type="text" class="form-control" name="password" placeholder="Password" id="password" required>
            <br>
            <button type="submit">Login</button>
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