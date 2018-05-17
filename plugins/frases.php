<?php
/*
frases.php
   Exibe uma frase randomicamente no seu site.

Programado por: 
Fábio Berbert de Paula <fabio@vivaolinux.com.br>
http://www.vivaolinux.com.br

Rio de Janeiro, 15 de Agosto de 2003
*/

$frases = array(
  "Quanto mais feliz, mais breve é o tempo. - Plínio",
  "Muitos sabem ganhar dinheiro, mas poucos sabem gastá-lo. - Henry David Thoreau",
  "Gostamos sempre de quem nos admira, mas nem sempre gostamos daqueles que admiramos. - François La Rochefoucauld",
  "Plagiar, é implicitamente, admirar. - Júlio Dantas",
  "Difícil é ganhar um amigo em uma hora; fácil é ofendê-lo em um minuto. - Provérbio Chinês",
  "É melhor conquistar a si mesmo do que vencer mil batalhas. - Buda",
  "O espaço mescla-se com o tempo assim como o corpo se mescla com a alma. - Friedrich Novalis",
  "Maior que a tristeza de não haver vencido é a vergonha de não ter lutado! - Rui Barbosa",
  "Se você pretende ser rico, pense em economizar tanto quanto em ganhar. - Benjamin Franklin",
  "A morte não é nada para nós, pois, quando existimos, não existe a morte, e quando existe a morte, não existimos mais. - Epicuro",
  "Quando temos muita luz, admiramo-nos pouco; mas, quando ela nos falta, acontece o mesmo. - Luc de Clapiers",
  "Sonhar é desinteressar-se. - Henri Bergson"
);

srand ((float)microtime()*1000000);
shuffle ($frases);

echo "Para refletir: " .$frases[0];
?>
