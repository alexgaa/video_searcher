<!DOCTYPE html>
<html>
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../public/css/users_index.css">
        <title><?php if (!isset($title)){ echo DEFAUL_TITLE; }?></title>
    </head>
    <body>
        <main>
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
                    <a class="navbar-brand" href="/main"><b>Video Searcher</b></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarColor02">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="/main/read">Просмотр <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/main/delete">Редактирование</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false">Последние результаты запуска</a>
                                <div class="dropdown-menu list-group-item-info">
                                    <a class="dropdown-item list-group-item-action list-group-item-info" href="/main/file-result">Файл с линками</a>
                                    <a class="dropdown-item list-group-item-action list-group-item-info" href="/main/file-comparison">Файл сравнения</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item list-group-item-action list-group-item-info" href="/main/file-error">файл с ошибками</a>
                                </div>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0" action='/exit'>
                            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Logout -></button>
                        </form>
                    </div>
                </nav>
            
            <div class="container-fluid">
                <div class="col-12">
                    <?=$content?>
                </div>
            </div>
        </main>
       <footer class="footer navbar-dark bg-primary">
            <div class="container">
                <div class="col mt-2">
                    <p class="text-center text-white">© 2020 Video Searcher</p>
                </div>
            </div>
        </footer>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
         <script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="../public/bootstrap/js/bootstrap.min.js"></script>
        <script src="../public/js/users.js" type="text/javascript"></script>
        <script src="../public/js/main.js" type="text/javascript"></script>
    </body>
</html>