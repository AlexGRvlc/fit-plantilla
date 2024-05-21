<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Figim - Inicio</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<link rel="stylesheet" href="css/styles.css" />

<body>
  <!-- Nav -->
  <div class="container-fluid">
    <div class="row">

      <nav class="navbar navbar-expand-lg" id="nav_bar">
        <a class="navbar-brand" href="#">
          <img src="public/img/logo.webp" alt="logo" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/login.php">Socios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/registro.php">Inscribete</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>


    <!-- TITULO -->
    <div class="row text-center" id="titulo_presentacion">
      <h1>FITGIM</h1>
      <p>Disfruta del deporte</p>
      <button type="button" class="btn btn-outline-success">Acceso a Socios</button>
    </div>

    <!-- EXPLORA -->
    <div class="row text-center d-flex justify-content-center " id="explora">
      <h1>EXPLORA</h1>
      <p>Entra en cada sección para informarte de las ventajas de ser uno
        de nuestros socios</p>


      <div class="col-4 box_explora">
        <h5 className="fs-30">ACTIVIDADES</h5>
        <p>
          Decide que actividades se adaptan a lo que buscas de entre las
          que ofrecemos.
        </p>
        <a href="pages/actividades.html">
          <button className="btn btn__hov">ACCEDE</button>
        </a>
      </div>


      <div class="col-4 box_explora ">
        <h5 className="fs-30">INSTALACIONES</h5>
        <p>
          Cada actividad dispone de un entorno adecuado para sacar el
          máximo rendimiento de tus sesiones.
        </p>
        <a href="pages/actividades.html">
          <button className="btn btn__hov">ACCEDE</button>
        </a>
      </div>


      <div class="col-4 box_explora ">
        <h5 className="fs-30">BONOS</h5>
        <p>
          Elije el que más te conviene según tus preferencias y cámbialo
          cuando quieras.
        </p>
        <a href="pages/actividades.html">
          <button className="btn btn__hov">ACCEDE</button>
        </a>
      </div>
    </div>

    <!-- HORARIO -->
    <div class="row" id="horario">
      <div class="col-12 d-flex  flex-column">
        <h2 class="text-center">HORARIO ACTIVIDADES</h2>
        <p class="text-center">Ponte al día con tu rutina semanal con la gama de actividades que
          tenemos para que las pruebes todas y elijas las que más te gusten.</p>
        <button>DESCARGA</button>
      </div>
      </a>
    </div>


    <!-- TIENDA -->
    <div class="row">
      <div class="col-8" id="img_tienda"></div>

      <div class="col-4" id="tienda">
        <h2 class="text-center">TIENDA ONLINE</h2>

        <p>
          Disponemos de una amplia gama de productos orientados a todas las
          necesidades de los usuarios. Reserva los suplementos que quieras y
          pasa a recogerlos cuando decidas.
        </p>
      </div>
    </div>

    <!-- CARACTERISTICAS -->
    <div class="row">
      <div class="text-center" id="caracteristicas">
        <h2>ESTAMOS PARA AYUDARTE</h2>
        <p>
          Inscríbete y disfruta de todas las ventajas de hacer deporte de
          forma guiada por profesionales
        </p>
      </div>
      <div class="col-4 box_caracteristicas">
        <img src="public/img/w-sport-1.png" alt="sport-1" />
        <h2 className="color-3"> Tabla de Entrenamiento </h2>
        <p className="color-3">
          Incluimos gratis una tabla de entrenamiento a corde a tus
          objetivos. Nuestros monitores de sala te guiarán sobre el uso de
          las máquinas y material del centro para facilitarte la
          adaptación.
        </p>
      </div>
      <div class="col-4 box_caracteristicas">
        <img src="public/img/w-sport-2.png" alt="sport-2" />
        <h2 className="color-3"> Todas las Actividades Incluidas </h2>
        <p className="color-3">
          Con tu inscripción todas las actividades dirigidas están
          incluidas, podrás acceder multitud de clases a la semana y a los
          programas más novedosos y actuales.
        </p>
      </div>
      <div class="col-4 box_caracteristicas">
        <img src="public/img/w-sport-3.png" alt="sport 3" />
        <h2 className="color-3"> Salas y Material de Entrenamiento </h2>
        <p className="color-3">
          Disfruta de las salas de fitness y musculación y de todo el
          material de entrenamiento del centro. Contarás con todo lo que
          necesites para realizar tus entrenamientos.
        </p>
      </div>
    </div>



  </div>


  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>