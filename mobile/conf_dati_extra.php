<?php
/*======================================================================+
 File name   : conf_mod_stud
 Begin       : 2010-08-04
 Last Update : 2013-01-29

 Description : inserting new extra confirmation

 Author: Sergio Capretta

 (c) Copyright:
               Sergio Capretta
             
               ITALY
               www.sinx.it
               info@sinx.it

Sinx for Association - Gestionale per Associazioni no-profit
    Copyright (C) 2011 by Sergio Capretta

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
=========================================================================+*/

  session_start();

$user = $_SESSION['utente'];
if ($user) {
	//$nnome = $_POST['nome'];
	$ncodice = $_POST['ntessera'];
	$nnome = $_POST['nome'];
	$ncognome = $_POST['cognome'];
	$nindirizzo = $_POST['indirizzo'];
	$cap = $_POST['comuni'];
	$ncitta = $_POST['regioni'];
	$nprovincia = $_POST['provincie'];
	$ndatangg = $_POST['datangg'];
	$ndatanmm = $_POST['datanmm'];
	$ndatanaaaa = $_POST['datanaaaa'];
	$ntel = $_POST['tel'];
	$ntel2 = $_POST['tel2'];
	$nmansione = $_POST['mansione'];
	$email = $_POST['email'];
	$nnote = $_POST['note'];
	$nomerif = $_POST['nomerif'];

$ndatan = ($ndatangg."-".$ndatanmm."-".$ndatanaaaa);

//protezione dati da codice html
$codice = htmlspecialchars($ncodice, ENT_NOQUOTES, "UTF-8");
$nome = htmlspecialchars($nnome, ENT_NOQUOTES, "UTF-8");
$cognome = htmlspecialchars($ncognome, ENT_NOQUOTES, "UTF-8");
$indirizzo = htmlspecialchars($nindirizzo, ENT_NOQUOTES, "UTF-8");
$citta = htmlspecialchars($ncitta, ENT_NOQUOTES, "UTF-8");
$provincia = htmlspecialchars($nprovincia, ENT_NOQUOTES, "UTF-8");
$tel = htmlspecialchars($ntel, ENT_NOQUOTES, "UTF-8");
$tel2 = htmlspecialchars($ntel2, ENT_NOQUOTES, "UTF-8");
$datan = htmlspecialchars($ndatan, ENT_NOQUOTES, "UTF-8");
$mansione = htmlspecialchars($nmansione, ENT_NOQUOTES, "UTF-8");
$note = htmlspecialchars($nnote, ENT_NOQUOTES, "UTF-8");



//Funzione per il redirect
function redirect($url,$tempo = FALSE ){
 if(!headers_sent() && $tempo == FALSE ){
  header('Location:' . $url);
 }elseif(!headers_sent() && $tempo != FALSE ){
  header('Refresh:' . $tempo . ';' . $url);
 }else{
  if($tempo == FALSE ){
    $tempo = 0;
  }
  echo "<meta http-equiv=\"refresh\" content=\"" . $tempo . ";" . $url . "\">";
  }
} 

// *** GESTIONE DELL'IMMAGINE ***
$upload_dir = "./Immagini/Utenti";
if(@is_uploaded_file($_FILES["immagine"]["tmp_name"])) {
$file_name = $_FILES["immagine"]["name"];
@move_uploaded_file($_FILES["immagine"]["tmp_name"], "$upload_dir/$file_name")
or die("Impossibile spostare il file, controlla l'esistenza o i permessi della directory dove fare l'upload.");

} else {

$file_name = "personal.gif";
@move_uploaded_file($_FILES["immagine"]["tmp_name"], "$upload_dir/$file_name");

}
// *** FINE MODULO GESTIONE IMMAGINE ***


	include ('./dati_db.inc');
	$connect = mysqli_connect("$host", "$username", "$password", "$db_name", $port ) or die("cannot connect DB");

$tb_anagrafe = ('tb_anagrafe(ntessera, nome, cognome, indirizzo, cap, citta, provincia, tel, tel2, mansione, email, nomerif, datan, tipologia, note, immagine)');
	if ($nome){ 
$sql="insert into $tb_anagrafe values('$codice', '$nome', '$cognome', '$indirizzo', '$cap', '$citta', '$provincia', '$tel', '$tel2', '$mansione', '$email', '$nomerif', '$datan', 'Extra', '$note', '$file_name')"; //inserisco i valori nel database
		$result=mysqli_query($connect, $sql);
		header('location: ./conferma.php?rif=InsAnagrExtra'); //Vado alla pagina di conferma
	}else{ 
		header('location: ./errore.php?rif=InsAnagrExtra'); //Vado alla pagina di errore
		}
mysqli_close($connect);
} else {
header('Location: ./index.php');
}
?>
