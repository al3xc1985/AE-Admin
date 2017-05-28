<?php
require_once('assets/MySQLConnection.php');
require_once('assets/AscEmuCommands.php');
require_once('assets/AscEmuCharDB.php');

$configs = include('config.php');
$alert = '';
?>

<!DOCTYPE html>

<html lang="en">
<head>
<title>AE-AdminPanel</title>
<style>
    body {
        background: url(images/ae-admin_back.jpg) no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    .block-area {
        padding: 15px 15px 0;
    }
    
    .border {
        border-top: 1px solid rgba(255,255,255,0.35);
    }
    /* The alert message box */
    .alert {
        padding: 20px;
        background-color: #1FA804;
        color: white;
        margin-bottom: 15px;
    }

    /* The close button */
    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    /* When moving the mouse over the close button */
    .closebtn:hover {
        color: black;
    }
    .dataTables_length {
        float: left;
        margin-top: 5px;
    }
    .paginate_button {
        padding: 5px 6px;
        border: 1px solid rgba(0,0,0,0.35);
        background: rgba(0,0,0,0.35);
        color: #fff;
    }
    .paginate_button:hover {
        padding: 5px 6px;
        border: 1px solid rgba(0,0,0,0.35);
        background: rgba(0,0,0,0.5);
        color: #fff;
        text-decoration: none;
    }
    .header_holder {
        padding: 0 0 15px;
    }
    .header_holder h2 {
        margin: 2px 0 1px 0;
        line-height: 29px;
        font-size: 30px;
        left: 10px;
        top: 10px;
        line-height: 100%;
        color: #fff;
    }
    .content_holder {
        background: rgba(0,0,0,0.35);
        padding: 10px;
        color: #fff;
    }
    .dataTables_length select {
        color: #000;
    }
    input[type=search] {
        color: #000;
    }
    tr.even {
        background: rgba(0,0,0,0.5);
        color: #fff;
    }
    tr.odd {
        background-color: none;
        background: rgba(0,0,0,0.35);
        color: #fff;
    }
    
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>AscEmu</title>
    <meta name="author" content="DankoDJ, Zyres">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navigation.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="widgets/astyle.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
</head>

<body>
    <?php
        $AECommand = new AECommands();

        if (isset($_GET['info']))
        {
            $alert = $AECommand->runInfoCommand();
        }
    
        if (isset($_GET['reloadscripts']))
        {
            $alert = $AECommand->runReloadScripts();
        }
    
        // init class
        $MySQLConnection = new MySQLConnection();

        // query
        $query = "SELECT Timestamp, Players, Latency, CPU_Usage, RAM_Usage FROM basic_information ORDER BY Timestamp DESC LIMIT 1";

        // get query result
        $row = $MySQLConnection->getResult($query);
    ?>

    <!-- Nav -->
    <nav class="navbar navbar-inverse sidebar" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="images/logo.svg"/></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity fa fa-home"></span></a></li>
                    <li class="active"><a href="#">Settings<span style="font-size:16px;" class="pull-right hidden-xs showopacity fa fa-sliders"></span></a></li>
                    <!--<li><a href="#">Profile<span style="font-size:16px;" class="pull-right hidden-xs showopacity fa fa-user"></span></a></li>
                    <li><a href="#">Messages<span style="font-size:16px;" class="pull-right hidden-xs showopacity fa fa-envelope"></span></a></li>
                    -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Commands <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity fa fa-terminal"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">
                            <li><a href='index.php?info'>Server Info</a></li>
                            <li><a href='index.php?reloadscripts'>Reload Scripts</a></li>
                            <!--<li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                            -->
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="main">
       <?php
        if ($alert != '')
            {
                echo '<div class="alert">
                          <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>'.$alert.'
                        </div>';
            }
        ?>
        <hr class="border"></hr>
        <div class="block-area">
            <div class="row">
                <div class="col-md-3 col-xs-6">
                    <?php include 'widgets/CPUGraph.php';?>
                </div>

                <div class="col-md-3 col-xs-6">
                    <?php include 'widgets/RAMGraph.php';?>
                </div>

                <div class="col-md-3 col-xs-6">
                    <?php include 'widgets/LatencyGraph.php';?>
                </div>

                <div class="col-md-3 col-xs-6">
                    <?php include 'widgets/OnlinePlayersGraph.php';?>
                </div>
            </div>
        </div>
        
        <hr class="border"></hr>
        
        <div class="block-area">
            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <div class="content_holder">
                        <div class="header_holder">
                            <h2>Playerlist</h2>
                            <small>LIST UPDATED: <?php echo date("Y-m-d H:i:s"); ?></small>
                        </div>
                        <?php
                            $AECcharDB = new AECharDatabase();

                            // get query result
                            $rows = $AECcharDB->getAllCharacters();
                            echo '<table id="characterList" class="table table-striped" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><small>GUID</small></th>
                                            <th><small>ACCOUNT</small></th>
                                            <th><small>NAME</small></th>
                                            <th><small>LEVEL</small></th>
                                            <th><small>RACE</small></th>
                                            <th><small>CLASS</small></th>
                                            <th><small>BANNED</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                            foreach ($rows as $result)
                            {
                                echo '<tr>
                                        <td>'.$result[0].'</td>
                                        <td>'.$result[1].'</td>
                                        <td>'.$result[2].'</td>
                                        <td>'.$result[7].'</td>
                                        <td>'.$result[3].'</td>
                                        <td>'.$result[4].'</td>';
                                
                                $banned = $result[33];
                                $bannResult = '';
                                if ($banned != 0)
                                {
                                    $bannResult = gmdate("Y-m-d H:i:s", $banned);
                                }
                                
                                echo '<td>'.$bannResult.'</td>
                                    </tr>';
                            }

                            echo '</tbody>
                            </table>';
                        ?>
                    </div>
                </div>

                <div class="col-md-6 col-xs-6">
                    Important stuff - right
                </div>
            </div>
        </div>
        <hr class="border"></hr>
        
    </div>

    <!-- javascript -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/navigation.js"></script>
    
    <script type="text/javascript" src="js/Chart.min.js"></script>
    
    <script type="text/javascript" src="widgets/OnlinePlayersGraph.js"></script>
    <script type="text/javascript" src="widgets/CPUGraph.js"></script>
    <script type="text/javascript" src="widgets/RAMGraph.js"></script>
    <script type="text/javascript" src="widgets/LatencyGraph.js"></script>
    <script>
                        $(document).ready(function() {
                            $('#characterList').DataTable({
                                responsive: true
                            });
                        } );
                    </script>
</body>
</html>