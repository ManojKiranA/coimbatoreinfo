<?php
$designDirAdmin  =   'adminlteassets';
$designDirFront  =   'frontendassets';
$bowerDir   =   'bower_components';
$distDir    =   'dist';
$plugDir    =   'plugins';


$constantArray = [

    'desgins'=>[

        'backend' => [

            'mainCss'=>
                        [
                        'Bootstrap 3.3.7'     => $designDirAdmin.'/'.$bowerDir.'/bootstrap/dist/css/bootstrap.min.css',
                        'Font Awesome'        => $designDirAdmin.'/'.$bowerDir.'/font-awesome/css/font-awesome.min.css',
                        'Ionicons'            => $designDirAdmin.'/'.$bowerDir.'/Ionicons/css/ionicons.min.css',
                        'Theme style'         => $designDirAdmin.'/'.$distDir.'/css/AdminLTE.min.css',
                        'AdminLTE Skins'      => $designDirAdmin.'/'.$distDir.'/css/skins/_all-skins.min.css',
                        'Google Font'         => 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic',
                        ],

            'mainJs' =>
                        [
                        'jQuery 3'            => $designDirAdmin.'/'.$bowerDir.'/jquery/dist/jquery.min.js',
                        'Bootstrap 3.3.7'     => $designDirAdmin.'/'.$bowerDir.'/bootstrap/dist/js/bootstrap.min.js',
                        'SlimScroll'          => $designDirAdmin.'/'.$bowerDir.'/jquery-slimscroll/jquery.slimscroll.min.js',
                        'FastClick'           => $designDirAdmin.'/'.$bowerDir.'/fastclick/lib/fastclick.js',
                        'AdminLTE App'        => $designDirAdmin.'/'.$distDir.'/js/adminlte.min.js',
                        // 'AdminLTE for demo purposes' => $designDirAdmin.'/'.$distDir.'/js/demo.js',
                        ],

            'busPageCss' => [
                            'Bootstrap time Picker' => $designDirAdmin.'/'.$plugDir.'/'.'timepicker/bootstrap-timepicker.min.css',
                            'Select2'               => $designDirAdmin.'/'.$bowerDir.'/select2/dist/css/select2.min.css',
                            ],
            'busPageJs' => [
                            'Bootstrap time Picker' => $designDirAdmin.'/'.$plugDir.'/'.'timepicker/bootstrap-timepicker.min.js',
                            'Select2'               => $designDirAdmin.'/'.$bowerDir.'/'.'select2/dist/js/select2.full.min.js',
                            ],
            ],

            'frontend' => 
                            [

                                'mainCss'=>
                                            [
                                            'Bootstrap 4.0.0'     => $designDirFront.'/'.'styles/bootstrap4/bootstrap.min.css',
                                            'Font Awesome'     => $designDirFront.'/'.'plugins/font-awesome-4.7.0/css/font-awesome.min.css',
                                            'Owl Carousel'     => $designDirFront.'/'.'plugins/OwlCarousel2-2.2.1/owl.carousel.css',
                                            'Owl Carousel Theme Default'     => $designDirFront.'/'.'plugins/OwlCarousel2-2.2.1/owl.theme.default.css',
                                            'Owl Carousel Animate'     => $designDirFront.'/'.'plugins/OwlCarousel2-2.2.1/animate.css',
                                            'Main Style'     => $designDirFront.'/'.'styles/main_styles.css',
                                            'Responsive Css'     => $designDirFront.'/'.'styles/responsive.css',
                                            
                                            
                                            ],

                        'mainJs' =>
                                    [
                                    'jQuery 3'            => $designDirFront.'/'.'js/jquery-3.2.1.min.js',
                                    'Bootstrap 4 Poper'            => $designDirFront.'/'.'styles/bootstrap4/popper.js',
                                    'Bootstrap 4'            => $designDirFront.'/'.'styles/bootstrap4/bootstrap.min.js',
                                    'OwlCarousel 2'            => $designDirFront.'/'.'plugins/OwlCarousel2-2.2.1/owl.carousel.js',
                                    'Isotope'            => $designDirFront.'/'.'plugins/Isotope/isotope.pkgd.min.js',
                                    'scrollTo'            => $designDirFront.'/'.'plugins/scrollTo/jquery.scrollTo.min.js',
                                    'easing'            => $designDirFront.'/'.'plugins/easing/easing.js',
                                    'parallax'            => $designDirFront.'/'.'plugins/parallax-js-master/parallax.min.js',
                                    'Custom Js'            => $designDirFront.'/'.'js/custom.js',                                    
                                    ],

                            ],

        

        'themeColor' => 'skin-purple',
    ],

];


// <!-- Select2 -->
// <script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
// <!-- bootstrap time picker -->
// <script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>




return $constantArray;
