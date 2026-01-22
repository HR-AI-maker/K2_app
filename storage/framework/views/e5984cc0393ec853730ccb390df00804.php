<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed customizer-hide" dir="ltr"
    data-skin="bordered"
    data-assets-path="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/assets/"
    data-base-url="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo-2"
    data-framework="laravel"
    data-template="blank-menu-template"
    data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Login Cover - Pak Alpine</title>
    <meta name="description" content="Sign in to Pak Alpine" />
    <meta name="keywords" content="login, pak alpine" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <link rel="canonical" href="<?php echo e(url('/login')); ?>" />
    <link rel="icon" type="image/x-icon" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/assets/img/favicon/favicon.ico" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="preload" as="style" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/iconify-CUuAgEs4.css" />
    <link rel="stylesheet" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/iconify-CUuAgEs4.css" />

    <link rel="preload" as="style" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/node-waves-CNx6tA5W.css" />
    <link rel="stylesheet" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/node-waves-CNx6tA5W.css" />
    <link rel="preload" as="style" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/pickr-themes-CFnMLNHJ.css" />
    <link rel="stylesheet" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/pickr-themes-CFnMLNHJ.css" />

    <link rel="preload" as="style" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/core-BbYdv-TE.css" />
    <link rel="preload" as="style" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/demo-Ct9D1Bdk.css" />
    <link rel="preload" as="style" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/perfect-scrollbar-CfyPsj0y.css" />
    <link rel="stylesheet" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/core-BbYdv-TE.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/demo-Ct9D1Bdk.css" />
    <link rel="stylesheet" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/perfect-scrollbar-CfyPsj0y.css" />

    <link rel="preload" as="style" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/typeahead-CROfg2SJ.css" />
    <link rel="stylesheet" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/typeahead-CROfg2SJ.css" />
    <link rel="preload" as="style" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/form-validation-Bg--itJV.css" />
    <link rel="stylesheet" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/form-validation-Bg--itJV.css" />

    <link rel="preload" as="style" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/page-auth-BQ0DSHJM.css" />
    <link rel="stylesheet" href="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/page-auth-BQ0DSHJM.css" />
</head>
<body>
    <div class="authentication-wrapper authentication-cover">
        <a href="<?php echo e(route('home')); ?>" class="app-brand auth-cover-brand">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="currentColor" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="currentColor" />
                    </svg>
                </span>
            </span>
            <span class="app-brand-text demo text-heading fw-bold">Pak Alpine</span>
        </a>

        <div class="authentication-inner row m-0">
            <div class="d-none d-xl-flex col-xl-8 p-0">
                <div class="auth-cover-bg d-flex justify-content-center align-items-center">
                    <img src="https://static.vecteezy.com/system/resources/thumbnails/038/967/730/small/mountain-climbing-route-to-peak-png.png"
                        alt="auth-login-cover" class="my-5 auth-illustration"
                        data-app-light-img="illustrations/auth-login-illustration-light.png"
                        data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
                    <img src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/assets/img/illustrations/bg-shape-image-light.png"
                        alt="auth-login-cover" class="platform-bg"
                        data-app-light-img="illustrations/bg-shape-image-light.png"
                        data-app-dark-img="illustrations/bg-shape-image-dark.png" />
                </div>
            </div>

            <div class="d-flex col-12 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
                <div class="w-px-400 mx-auto mt-12 pt-5">
                    <h4 class="mb-1">Welcome to Pak Alpine</h4>
                    <p class="mb-6">Sign in to your account to continue</p>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form id="formAuthentication" class="mb-6" action="<?php echo e(route('login')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-6 form-control-validation">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email" value="<?php echo e(old('email')); ?>" autofocus required />
                        </div>
                        <div class="mb-6 form-password-toggle form-control-validation">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="********" required />
                                <span class="input-group-text cursor-pointer">
                                    <i class="icon-base ti tabler-eye-off"></i>
                                </span>
                            </div>
                        </div>
                        <div class="my-8">
                            <div class="d-flex justify-content-between">
                                <div class="form-check mb-0 ms-2">
                                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                                    <label class="form-check-label" for="remember-me">Remember me</label>
                                </div>
                                <a href="#">
                                    <p class="mb-0">Forgot Password?</p>
                                </a>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100">Sign in</button>
                    </form>

                    <p class="text-center">
                        <span>New here?</span>
                        <a href="<?php echo e(route('register')); ?>">
                            <span>Create an account</span>
                        </a>
                    </p>

                    <div class="divider my-6">
                        <div class="divider-text">or</div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook me-1_5">
                            <i class="icon-base ti tabler-brand-facebook-filled icon-20px"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter me-1_5">
                            <i class="icon-base ti tabler-brand-twitter-filled icon-20px"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github me-1_5">
                            <i class="icon-base ti tabler-brand-github-filled icon-20px"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
                            <i class="icon-base ti tabler-brand-google-filled icon-20px"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/helpers-DAoeyj3E.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/template-customizer-DBKgDaSZ.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/config-BoP0Nie5.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/jquery-Bou6iJJX.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/popper-MwzM93Hw.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/bootstrap-DJKADUhV.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/node-waves-DPhnNaCB.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/autocomplete-js-BLyOkDc2.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/pickr-71-TLRtn.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/perfect-scrollbar-D2XDwrzR.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/hammer-DLEdXtvS.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/menu-Cc3Gq5JA.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/popular-DHD2IDQ4.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/bootstrap5-B8xweYSi.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/auto-focus-gx3LVEfk.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/main-Ccsc20-B.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/pages-auth-D0KVgRoL.js"></script>
    <script type="module" src="https://demos.pixinvent.com/vuexy-html-laravel-admin-template/demo/build/assets/app-T1DpEqax.js"></script>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\alpine\resources\views/auth/login.blade.php ENDPATH**/ ?>