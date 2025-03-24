<!DOCTYPE html>
<html lang="en">
	<head>

        <!-- Basic -->
        <title>ADC Plataforma | SEDYCO</title>

        <meta name="keywords" content="ADC - SEDYCO" />
        <meta name="description" content="Plataforma para la Evaluación al Desempeño y el Clima Organizacional">
        <meta name="author" content="NetInnfode">

        <!-- Favicon -->
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
        <link rel="apple-touch-icon" href="img/apple-touch-icon.png">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

        <!-- Web Fonts  -->
        <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="vendor/animate/animate.compat.css">
        <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
        <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
        <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">

        <!-- Theme CSS -->
        <link rel="stylesheet" href="css/theme.css">
        <link rel="stylesheet" href="css/theme-elements.css">
        <link rel="stylesheet" href="css/theme-blog.css">
        <link rel="stylesheet" href="css/theme-shop.css">

        <!-- Demo CSS -->
        <link rel="stylesheet" href="css/demos/demo-business-consulting-3.css">

        <!-- Skin CSS -->
        <link id="skinCSS" rel="stylesheet" href="css/skins/skin-business-consulting-3.css">

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="css/custom.css">
	</head>

	<body data-plugin-cursor-effect>
		<div class="body">
            <header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 85}">
                <div class="header-body border-top-0">
                    <div class="header-top header-top-default header-top-borders border-bottom-0 bg-color-light">
                        <div class="container">
                            <div class="header-row">
                                <div class="header-column justify-content-between">
                                    <div class="header-row">
                                        <nav class="header-nav-top w-100 w-md-50pct w-xl-100pct">
                                            <ul class="nav nav-pills d-inline-flex custom-header-top-nav-background pe-5">
                                                <li class="nav-item py-2 d-inline-flex z-index-1">
													<span class="font-weight-normal align-items-center px-0 d-none d-xl-flex ms-3">
														<span>
															<img width="25" src="img/demos/adc/icons/email.svg" alt="Email Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light'}" />
														</span>
														<a class="text-color-light text-decoration-none font-weight-semibold text-3-5 ms-2" href="mailto:contactorh@adcentrales.com" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light">contactorh@adcentrales.com</a>
													</span>
                                                </li>
                                            </ul>
                                        </nav>
                                        <div class="d-flex align-items-center w-100">
                                            <ul class="ps-0 ms-auto mb-0">
                                                <li class="nav-item font-weight-semibold text-1 text-lg-2 text-color-dark d-none d-md-flex justify-content-end me-3">
                                                    <!--	Mon - Sat 9:00am - 6:00pm / Sunday - CLOSED -->
                                                </li>
                                            </ul>
                                            <ul class="social-icons social-icons-clean social-icons-icon-dark social-icons-big m-0 ms-lg-2">
                                                <li class="social-icons-instagram">
                                                    <a href="http://www.instagram.com/" target="_blank" class="text-4" title="Instagram" data-cursor-effect-hover="fit"><i class="fab fa-instagram"></i></a>
                                                </li>
                                                <li class="social-icons-twitter">
                                                    <a href="http://www.twitter.com/" target="_blank" class="text-4" title="Twitter" data-cursor-effect-hover="fit"><i class="fab fa-x-twitter"></i></a>
                                                </li>
                                                <li class="social-icons-facebook">
                                                    <a href="http://www.facebook.com/" target="_blank" class="text-4" title="Facebook" data-cursor-effect-hover="fit"><i class="fab fa-facebook-f"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-container container" style="height: 117px;">
                        <div class="header-row">
                            <div class="header-column">
                                <div class="header-row">
                                    <div class="header-logo">
                                        <a href="#">
                                            <img alt="Porto" width="192" height="82" src="img/logo_header_home.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="header-column justify-content-end w-100">
                                <div class="header-row">
                                    <div class="header-nav header-nav-links order-2 order-lg-1">
                                        <div class="header-nav-main header-nav-main-square header-nav-main-text-capitalize header-nav-main-effect-1 header-nav-main-sub-effect-1">
                                            <nav class="collapse">
                                                <ul class="nav nav-pills" id="mainNav">
                                                    <li>
                                                        <a class="nav-link" href="{{route('welcome')}}">
                                                            Inicio
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="{{ route('about') }}">
                                                            Acerca de Nosotros
                                                        </a>
                                                    </li>
                                                    <li class="dropdown">
                                                        <a class="nav-link dropdown-toggle" href="{{route('modules')}}">
                                                            Módulos
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{route('modules-360-detail')}}" class="dropdown-item">
                                                                    Evaluación 360
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('modules-f2f')}}" class="dropdown-item">
                                                                    Face to Face
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('modules-9box')}}" class="dropdown-item">
                                                                    9 Box
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('modules-clima')}}" class="dropdown-item">
                                                                    Clima Organizacional
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('modules-tablero-de-control')}}" class="dropdown-item">
                                                                    Tablero de control
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('modules-portafolio')}}" class="dropdown-item">
                                                                    Portafolio
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('modules-nom035')}}" class="dropdown-item">
                                                                    NOM 035
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('modules-psicometria')}}" class="dropdown-item">
                                                                    Psicometrías
                                                                </a>
                                                            </li>

                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link active" href="{{route('questions')}}">
                                                            Preguntas Frecuentes
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="{{ route('contact') }}">
                                                            Directorio
                                                        </a>
                                                    </li>

                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="header-column header-column-search justify-content-end align-items-center d-flex w-auto flex-row">
                                <a href="/dashboard" class="btn btn-dark custom-btn-style-1 font-weight-semibold text-3-5 btn-px-3 py-2 ws-nowrap ms-4 d-none d-lg-block" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light"><span>Ingresar</span></a>
                                <div class="header-nav-features header-nav-features-no-border">
                                    <div class="header-nav-feature header-nav-features-search d-inline-flex">
                                        <a href="#" class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch" aria-label="Search">
                                            <i class="icons icon-magnifier header-nav-top-icon text-3-5 text-color-dark text-color-hover-primary font-weight-semibold top-3"></i>
                                        </a>
                                        <div class="header-nav-features-dropdown header-nav-features-dropdown-mobile-fixed border-radius-0" id="headerTopSearchDropdown">
                                            <form role="search" action="#" method="get">
                                                <div class="simple-search input-group">
                                                    <input class="form-control text-1" id="headerSearch" name="q" type="search" value="" placeholder="Buscar...">
                                                    <button class="btn" type="submit" aria-label="Search">
                                                        <i class="icons icon-magnifier header-nav-top-icon text-color-dark text-color-hover-primary top-2"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

			<div role="main" class="main">

				<section class="section mt-4 mb-5 section-with-shape-divider page-header page-header-modern page-header-lg border-0 my-0 lazyload" data-bg-src="img/demos/business-consulting-3/backgrounds/background-5.jpg" style="background-size: cover; background-position: center;">
					<div class="container pb-5 my-3">
						<div class="row mb-4">
							<div class="col-md-12 align-self-center p-static order-2 text-center">
								<h1 class="font-weight-bold text-color-dark text-10">Preguntas Frecuentes</h1>
							</div>
							<div class="col-md-12 align-self-center order-1">
								<ul class="breadcrumb d-block text-center">
									<li><a href="{{route('welcome')}}">Inicio</a></li>
									<li class="active">Preguntas</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="shape-divider shape-divider-bottom shape-divider-reverse-x" style="height: 123px;">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1920 123" preserveAspectRatio="xMinYMin">
							<polygon fill="#F3F3F3" points="0,90 221,60 563,88 931,35 1408,93 1920,41 1920,-1 0,-1 "/>
							<polygon fill="#FFFFFF" points="0,75 219,44 563,72 930,19 1408,77 1920,25 1920,-1 0,-1 "/>
						</svg>
					</div>
				</section>

				<div class="container pt-3 mt-4 mb-5">


					<div class="row row-gutter-sm pt-4 pt-sm-0">
						<div class="col-md-8 col-lg-9 mb-5 mb-md-0">
                            <div class="accordion custom-accordion-style-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250" id="accordion1">
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingOne">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1One" aria-expanded="false" aria-controls="collapse1One">
                                                1 - ¿Cómo ingresar a la plataforma?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1One" class="collapse" aria-labelledby="collapse1HeadingOne" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Para ingresar a la plataforma, primero asegúrate de tener tus credenciales (usuario y contraseña). Dirígete al sitio web oficial o abre la aplicación móvil, haz clic en "Ingresar", introduce tu usuario y contraseña, y presiona "Entrar". Si es tu primera vez, es posible que necesites registrarte o activar tu cuenta mediante un enlace enviado a tu correo.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingTwo">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Two" aria-expanded="false" aria-controls="collapse1Two">
                                                2 - ¿Cuál es mi usuario y contraseña?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Two" class="collapse" aria-labelledby="collapse1HeadingTwo" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Tu usuario generalmente es tu correo electrónico registrado o un identificador proporcionado por la plataforma (correo institucional). La contraseña inicial suele enviarse a tu correo al registrarte. Si no la tienes, pregunta al responsable de Recursos Humanos de tu Central o revisa tu bandeja de entrada (o la carpeta de spam) o sigue el proceso de recuperación de contraseña.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingThree">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Three" aria-expanded="false" aria-controls="collapse1Three">
                                                3 - ¿Puedo cambiar mi contraseña?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Three" class="collapse" aria-labelledby="collapse1HeadingThree" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Sí, puedes cambiar tu contraseña. Ve a la sección de "Configuración" o "Perfil" dentro de la plataforma, busca la opción "Cambiar contraseña", introduce tu contraseña actual y la nueva contraseña, y confirma el cambio. Asegúrate de usar una contraseña segura con letras, números y símbolos.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingFour">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Four" aria-expanded="false" aria-controls="collapse1Four">
                                                4 - ¿A quién notifico de un error?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Four" class="collapse" aria-labelledby="collapse1HeadingFour" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Si encuentras un error, puedes notificarlo al equipo de soporte técnico. Notifica a tu responsable de RH de tu central o busca la sección de "Ayuda" o "Soporte" en la plataforma, donde suele haber un formulario de contacto o un correo electrónico (como contact@adcentrales.com). Proporciona detalles del error, como capturas de pantalla y una descripción clara.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingFive">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Five" aria-expanded="false" aria-controls="collapse1Five">
                                                5 - ¿Cuáles son los documentos que debo de cargar?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Five" class="collapse" aria-labelledby="collapse1HeadingFive" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Los documentos requeridos deberás de entregárselos al responsable de RH, una vez cargados por el responsable tus documentos estarán disponibles en el apartado portafolio digital.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingSix">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Six" aria-expanded="false" aria-controls="collapse1Six">
                                                6 - ¿Qué pasa si no contesté las evaluaciones?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Six" class="collapse" aria-labelledby="collapse1HeadingSix" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Si no contestaste las evaluaciones dentro del plazo establecido, es posible que tu evaluación se vea afectada. Sin embargo, algunas plataformas permiten solicitar una extensión o una nueva oportunidad contactando al administrador o al área de recursos humanos.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingSeven">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Seven" aria-expanded="false" aria-controls="collapse1Seven">
                                                7 - ¿Es posible volver a evaluar a un colaborador?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Seven" class="collapse" aria-labelledby="collapse1HeadingSeven" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">No, las políticas de la plataforma y de la organización, no permite volver a evaluar a un colaborador. Si crees que hubo algún error, puedes comentar cual fue el error al equipo de recursos humanos, justificando la necesidad de una reevaluación.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingEight">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Eight" aria-expanded="false" aria-controls="collapse1Eight">
                                                8 - ¿Puedo consultar mi cuenta si no tengo datos en mi celular?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Eight" class="collapse" aria-labelledby="collapse1HeadingEight" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Sí, siempre y cuando tengas acceso a una conexión Wi-Fi segura. Sin embargo, algunas funciones que requieran sincronización en tiempo real o actualizaciones pueden necesitar una conexión de datos activa.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingNine">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Nine" aria-expanded="false" aria-controls="collapse1Nine">
                                                9 - ¿Puedo bajar documentos de mi expediente digital?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Nine" class="collapse" aria-labelledby="collapse1HeadingNine" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Sí, puedes descargar los documentos de tu expediente digital directamente desde la aplicación, siempre y cuando tengas acceso a una conexión a internet. Los documentos estarán disponibles para su descarga en formatos compatibles, como PDF y podrás almacenarlos en tu dispositivo para acceder a ellos sin conexión en el futuro.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingTen">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Ten" aria-expanded="false" aria-controls="collapse1Ten">
                                                10 - ¿Puedo consultar mis resultados de la evaluación 360°?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Ten" class="collapse" aria-labelledby="collapse1HeadingTen" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Los resultados de la evaluación 360° se manejan de forma confidencial para garantizar la privacidad y el análisis imparcial. Por lo tanto, no es posible consultar los resultados directamente en la aplicación.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingEleven">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Eleven" aria-expanded="false" aria-controls="collapse1Eleven">
                                                11 - ¿Está disponible en diferentes dispositivos o sistemas operativos?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Eleven" class="collapse" aria-labelledby="collapse1HeadingEleven" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Sí, nuestra aplicación está disponible en varios dispositivos y sistemas operativos, incluyendo Android, iOS y en la versión web. Puedes acceder a ella desde tu celular, tablet o computadora, asegurando una experiencia fluida y accesible en cualquier momento y lugar.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingTwelve">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Twelve" aria-expanded="false" aria-controls="collapse1Twelve">
                                                12 - ¿Qué debo hacer si olvido mi contraseña?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Twelve" class="collapse" aria-labelledby="collapse1HeadingTwelve" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Si olvidas tu contraseña, no te preocupes. Solo tienes que hacer clic en la opción directorio, enviar a tu contacto de sede la solicitud de restablecer la contraseña y a través de un correo recibirás las instrucciones para poder ingresar con una contraseña provisional, que te permitirá acceder para cambiar tu nueva contraseña.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingThirteen">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Thirteen" aria-expanded="false" aria-controls="collapse1Thirteen">
                                                13 - ¿Requiero de mucho tiempo para completar las actividades?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Thirteen" class="collapse" aria-labelledby="collapse1HeadingThirteen" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">El tiempo necesario para completar las actividades depende de las fechas establecidas de cada tarea o evaluación asignada.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingFourteen">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Fourteen" aria-expanded="false" aria-controls="collapse1Fourteen">
                                                14 - ¿La aplicación tiene opción de personalización?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Fourteen" class="collapse" aria-labelledby="collapse1HeadingFourteen" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">[Respuesta pendiente de proporcionar].</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingFifteen">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Fifteen" aria-expanded="false" aria-controls="collapse1Fifteen">
                                                15 - ¿Cómo protege la aplicación mi privacidad y datos personales?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Fifteen" class="collapse" aria-labelledby="collapse1HeadingFifteen" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Tu privacidad y seguridad son nuestra prioridad. La aplicación utiliza tecnologías avanzadas de encriptación para proteger tus datos personales y garantizar que toda la información se maneje de manera confidencial.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingSixteen">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Sixteen" aria-expanded="false" aria-controls="collapse1Sixteen">
                                                16 - ¿Es anónima la participación en ejercicios o actividades dentro de la app?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Sixteen" class="collapse" aria-labelledby="collapse1HeadingSixteen" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">Tu información personal se mantiene protegida y solo se utiliza para mejorar tu experiencia dentro de la aplicación. Puedes consultar nuestra política de privacidad para obtener más detalles sobre cómo manejamos tus datos.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header" id="collapse1HeadingSeventeen">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1Seventeen" aria-expanded="false" aria-controls="collapse1Seventeen">
                                                17 - ¿Cuál es el objetivo principal de la aplicación?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1Seventeen" class="collapse" aria-labelledby="collapse1HeadingSeventeen" data-bs-parent="#accordion1">
                                        <div class="card-body">
                                            <p class="mb-0">El objetivo es ayudarte en tu desarrollo personal y profesional. Nuestra misión es brindarte los recursos necesarios para que puedas alcanzar tus metas y crecer de personal y profesional.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
						<div class="col-md-4 col-lg-3 text-center text-md-start">
							<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">
								<h3 class="font-weight-semibold text-color-dark text-transform-none text-5-5 mb-3">Tienes más dudas?</h3>
								<p class="pb-1 mb-2">Te invitamos a que contactes al responsable de RH de tu terminal. </p>
								<span class="d-flex align-items-center justify-content-center justify-content-md-start pb-2 mb-3">
									<span>
										<div class="animated-icon animated fadeIn svg-fill-color-primary"><!--?xml version="1.0" encoding="utf-8"?-->
<svg version="1.1" id="icon_91742787662047" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve" data-filename="email.svg" width="25" height="25">
<path d="M32,60C16.5,60,4,47.5,4,32S16.5,4,32,4c15.9,0,25,8.7,25,24v1c0.2,3.4-0.6,6.8-2.3,9.7c-1.8,3.1-5.1,5.1-8.7,5
	c-4,0-8.6-2.3-8.6-8.8v-0.1L38,22.9c-0.5-0.1-1-0.2-1.5-0.3c-1.4-0.2-2.7-0.3-4.1-0.3c-2.5-0.1-5,0.8-6.7,2.7
	c-1.8,2.1-2.8,4.8-2.6,7.6c-0.1,2.2,0.5,4.3,1.7,6.1c1.1,1.3,2.7,1.9,4.3,1.8c1.2,0,2.4-0.3,3.4-0.9c0.9-0.6,2.2-0.4,2.8,0.6
	s0.4,2.2-0.6,2.8C33,44,31,44.6,29.1,44.5c-2.8,0.1-5.6-1.1-7.4-3.3c-1.8-2.1-2.6-5-2.6-8.7c-0.2-3.8,1.1-7.5,3.7-10.3
	c2.5-2.7,6-4.1,9.7-4c1.6,0,3.1,0.1,4.7,0.4c1.2,0.2,2.4,0.4,3.5,0.7l1.6,0.4L41.4,35c0,4.1,2.9,4.7,4.6,4.7c2.1,0,4.1-1.1,5.2-2.9
	c1.4-2.4,2-5.1,1.8-7.8v-1c0-12.9-7.5-20-21-20C18.7,8,8,18.7,8,32c0,13.3,10.7,24,24,24c6.2,0,12.1-2.4,16.6-6.7
	c0.8-0.8,2.1-0.7,2.8,0.1c0.8,0.8,0.7,2.1-0.1,2.8l0,0C46.2,57.2,39.2,60,32,60z"></path>
</svg></div>
									</span>
									<a class="text-color-dark text-color-hover-primary text-decoration-none font-weight-semibold text-3-5 ms-2" href="mail-to:contact@adcentrales.com">contact@adcentrales.com</a>
								</span>
								<a href="{{route('contact')}}" class="btn btn-primary custom-btn-style-1 font-weight-semibold btn-px-4 btn-py-2 text-3-5 mb-3" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light"><span>Directorio</span></a>

								<hr class="my-4">
							</div>
							<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">
								<h3 class="font-weight-semibold text-color-dark text-transform-none text-5-5 pt-2 mb-3">Listo para empezar?</h3>
								<p class="pb-1 mb-3"> Inicia sesión y conoce la plataforma.  </p>
								<a href="/dashboard" class="btn btn-dark custom-btn-style-1 font-weight-semibold btn-px-4 btn-py-2 text-3-5" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light"><span>Ingresar</span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
            <footer id="footer" class="border-top-0 m-0 lazyload" data-bg-src="img/demos/adc/backgrounds/background-4.jpg" style="background-size: cover; background-position: center; background-repeat: no-repeat;">
                <div class="container pt-3">
                    <div class="row justify-content-between align-items-center py-5 mb-3">
                        <div class="col-auto mb-4 mb-lg-0">
                            <h2 class="font-weight-semibold text-color-light text-10 ls-0 mb-0">¿Estás listo para empezar?</h2>
                        </div>
                        <div class="col-auto">
                            <a href="/dashboard" class="btn btn-primary custom-btn-style-1 font-weight-medium btn-px-4 btn-py-2 text-4" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light">
                                <span class="text-color-light">Ingresar</span>
                            </a>
                        </div>
                    </div>
                    <hr class="bg-color-light opacity-1 my-0">
                    <div class="row pt-3 mt-5">
                        <div class="col-lg-2 mb-4 mb-lg-0">
                        </div>
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <a href="demo-business-consulting-3.html" class="text-decoration-none">
                                <img src="img/logo_footer.png" class="img-fluid mb-4" width="123" height="33" alt="" />
                            </a>
                            <p class="text-3-5">
                                Somos la administradora de centrales líder en el mercado, impulsando la vanguardia en cada viaje. Nos dedicamos a ofrecerte una experiencia de viaje excepcional, donde la comodidad y la eficiencia son nuestra prioridad.
                            </p>
                            <ul class="social-icons social-icons-clean social-icons-clean-with-border social-icons-medium social-icons-icon-light">
                                <li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook" data-cursor-effect-hover="fit"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="social-icons-twitter mx-2"><a href="http://www.twitter.com/" target="_blank" title="Twitter" data-cursor-effect-hover="fit"><i class="fab fa-x-twitter"></i></a></li>
                                <li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin" data-cursor-effect-hover="fit"><i class="fab fa-linkedin-in"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 mb-4 mb-lg-0">
                            <ul class="list list-icons list-icons-lg">
                                <li class="d-flex px-0 mb-1">
                                    <img width="25" src="img/demos/business-consulting-3/icons/phone.svg" alt="Phone Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light'}" />
                                    <a href="tel:8001234567" class="text-color-light font-weight-semibold text-3-4 ms-2">(800) 123-4567</a>
                                </li>
                                <li class="d-flex px-0 my-3">
                                    <img width="25" src="img/demos/business-consulting-3/icons/email.svg" alt="Email Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light'}" />
                                    <a href="mailto:contactorh@adcentrales.com" class="text-color-light font-weight-semibold text-3-4 ms-2">contactorh@adcentrales.com</a>
                                </li>
                                <li class="d-flex font-weight-semibold text-color-light px-0 mb-1">
                                    <img width="25" src="img/demos/business-consulting-3/icons/map-pin.svg" alt="Location" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light me-2'}" />
                                    Hilario Medina, León, Guanajuato 37000, México
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 mb-4 mb-lg-0">

                            <h4 class="font-weight-bold text-5">Links</h4>
                            <ul class="list list-icons list-icons-sm">
                                <li>
                                    <i class="fas fa-angle-right text-color-default"></i>
                                    <a href="{{route('welcome')}}" class="link-hover-style-1 ms-1"> Inicio</a>
                                </li>
                                <li>
                                    <i class="fas fa-angle-right text-color-default"></i>
                                    <a href="{{route('about')}}" class="link-hover-style-1 ms-1">Acerca de Nosotros</a>
                                </li>
                                <li>
                                    <i class="fas fa-angle-right text-color-default"></i>
                                    <a href="{{route('modules')}}" class="link-hover-style-1 ms-1"> Módulos</a>
                                </li>
                                <li>
                                    <i class="fas fa-angle-right text-color-default"></i>
                                    <a href="{{route('questions')}}" class="link-hover-style-1 ms-1"> Preguntas Frecuentes</a>
                                </li>

                            </ul>
                        </div>
                        <div class="col-lg-2 mb-4 mb-lg-0">
                        </div>
                    </div>
                </div>
                <div class="footer-copyright container bg-transparent">
                    <div class="row pb-5">
                        <div class="col-lg-12 text-center m-0">
                            <hr class="bg-color-light opacity-1 mt-5 mb-4">
                            <p class="text-3-4">ADC Administradora de Centrales . © {{ date('Y') }}. Todos los derechos Reservados</p>
                        </div>
                    </div>
                </div>
            </footer>


		</div>

		<!-- Vendor -->
		<script src="vendor/plugins/js/plugins.min.js"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>

		<!-- Current Page Vendor and Views -->
		<script src="js/views/view.contact.js"></script>

		<!-- Theme Custom -->
		<script src="js/custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>

	<!-- Google Maps -->

	</body>
</html>
