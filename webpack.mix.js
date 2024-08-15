const mix = require('laravel-mix');

mix.js('resources/js/setting/profile.js', 'public/js/setting/profile.js')
   .js('resources/js/setting/settingSystem.js', 'public/js/setting/settingSystem.js')
   .js('resources/js/forms/leaveForms.js', 'public/js/forms/leaveForms.js')
   .js('resources/js/forms/getLeaveForm.js', 'public/js/forms/getLeaveForm.js')
   .js('resources/js/loadingView.js', 'public/js/loadingView.js')
   .js('resources/js/formManagement.js', 'public/js/formManagement.js')
   .js('resources/js/forms/jobRequestForm.js', 'public/js/forms/jobRequestForm.js')
   .js('resources/js/forms/getJobRequestForm.js', 'public/js/forms/getJobRequestForm.js')
   .postCss('resources/css/setting/profile.css', 'public/css/setting/profile.css')
   .postCss('resources/css/setting/settingSystem.css', 'public/css/setting/settingSystem.css')
   .postCss('resources/css/forms/leaveForms.css', 'public/css/forms/leaveForms.css')
   .postCss('resources/css/formManagement.css', 'public/css/formManagement.css')
   .postCss('resources/css/forms/jobRequestForm.css', 'public/css/forms/jobRequestForm.css')
   .postCss('resources/css/layouts/app.css', 'public/css/layouts/app.css');
