<!-- Barra lateral / Menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
    <div class="w3-container">
        <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-jumbo w3-padding w3-hover-grey" title="close menu">
            <i class="fa fa-remove"></i>
        </a>
        <img src="imagens/logo.jpg" style="width:70%;" class="w3-round"><br><br><br>
        <h4><b>Gestor Equipamentos</b></h4><br>
    </div>
    <div class="w3-bar-block">
        <a href="3-form_inserir.php" class="w3-bar-item w3-button w3-padding<?php
                                                                            if (basename($_SERVER['PHP_SELF']) == '3-form_inserir.php') echo " w3-text-teal";
                                                                            ?>"><i class="fa fa-eject fa-fw w3-margin-right"></i>INSERIR EQUIPAMENTOS</a>
        <a href="produtos.php" class="w3-bar-item w3-button w3-padding<?php
                                                                        if (basename($_SERVER['PHP_SELF']) == 'produtos.php') echo " w3-text-teal";
                                                                        ?>"><i class="fa fa-th-large fa-fw w3-margin-right"></i>EQUIPAMENTOS</a>
        <a href="lista_emprestimo.php" class="w3-bar-item w3-button w3-padding<?php
                                                                    if (basename($_SERVER['PHP_SELF']) == 'lista_emprestimo.php') echo " w3-text-teal";
                                                                    ?>"><i class="fas fa-share-square fa-fw w3-margin-right"></i>EMPRÉSTIMOS ATIVOS</a>
        <a href="lista_reservas.php" class="w3-bar-item w3-button w3-padding<?php
                                                                    if (basename($_SERVER['PHP_SELF']) == 'lista_reservas.php') echo " w3-text-teal";
                                                                    ?>"><i class="far fa-clock fa-fw w3-margin-right"></i>RESERVAS ATIVAS</a>
        <br><br><br>
        <a href="adicionalmente/logout.php" class="w3-bar-item w3-button w3-padding"><i class="fas fa-sign-out-alt fa-fw"></i>TERMINAR SESSÃO</a>
    </div>
    <div class="w3-panel w3-large">
        <a href="https://pt-pt.facebook.com/AgrupamentoDeEscolasFranciscoDeHolanda" target="_blank"><i class="fab fa-facebook-square w3-hover-opacity w3-text-black"></i></a>
        <a href="https://www.instagram.com/aefranciscoholanda" target="_blank"> <i class="fab fa-instagram-square w3-hover-opacity w3-text-black"></i></a>
        <a href="https://www.youtube.com/user/AeFranciscoHolanda" target="_blank"> <i class="fab fa-youtube-square w3-hover-opacity w3-text-black"></i></a>
    </div>
</nav>