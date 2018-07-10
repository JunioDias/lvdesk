<?php
include("../controllers/conexao.inc.php");
if ($_SESSION['mail_box']) {
	$mail_box = $_SESSION['mail_box'];
    $total_de_mensagens = imap_num_msg($mail_box);
	echo "<h4>Total de Mensagens: ".$total_de_mensagens."</h4>";
    if ($total_de_mensagens > 0) {
        for ($mensagem = 1; $mensagem <= $total_de_mensagens; $mensagem++) {
			/*
            echo '<pre>';
                print_r(imap_headerinfo($mail_box, $mensagem));
            echo '</pre>';

            
             *  o terceiro parametro pode ser
             *  0=> retorna o body da mensagem com o texto que o servidor recebe
             *  1=> retorna somente o conteudo da mensagem em plain-text
             *  2=> retorna o conteudo da mensagem em html
            */

            echo "<hr />";
            $body_2 = (imap_fetchbody($mail_box, $mensagem, 2) );
            echo $body_2;

            echo "<hr />";
            // deixei comentando pra não dar problema e excluir todos seus e-mails
            
            //imap_delete($mail_box, $mensagem);
            //imap_expunge($mail_box);
        }
    }
    imap_close($mail_box); 
}
?>