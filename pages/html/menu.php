<div class="container">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-9 col-sm-4 col-md-4">
                    <img class="navbar-brand" src="images/facebook.svg" />
                </div>
                <div class="navbar-form navbar-left"> 
                    <div id="imaginary_container"> 
                        <div class="input-group stylish-input-group">
                            <input type="text" class="form-control"  placeholder="Search" >
                            <span class="input-group-addon">
                                <button type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>  
                            </span>
                        </div>
                    </div>
                </div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form id="signin" class="navbar-form navbar-right" role="form" method="POST" action="">
                        <button type="submit" class="btn btn-primary" name="submit" formaction="" value="Session:accessHome">Home</button>
                        <button type="submit" class="btn btn-primary" name="submit" formaction="" value="Session:messenger">Messenger</button>
                        <button type="submit" class="btn btn-primary" name="submit" formaction="" value="Session:logOut">Log out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</div>


<?php 
    echo "Coucou " . Session::getConnectedPerson()->getNickname() . " ! "; 
?>

</br>