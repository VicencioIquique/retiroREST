<?php
class Promocion
{
    // Declaración de una propiedad
	private $nombre = '';
	private $idPack = '';
	private $Productos =[];

	function __construct($nombre,$idPack,$Productos){
		$this->nombre = $nombre;
		$this->idPack = $idPack;
		$this->Productos = $Productos;
	}
	public function getIdPack(){
		return ($this->idPack);
	}
	public function getProductos(){
		return ($this->Productos);
	}
	public function tamano(){
		return sizeof($this->Productos);
	}
}
$promociones=[];
$promociones[0]= new Promocion("Pack Renovación Total","001",['8716716044567'=>4800,'8716716044796'=>8700,'8719134012897'=>9700,'8719134020854'=>11300]);//up
$promociones[1]= new Promocion("Pack Felicidad Total","002",['8719134015355'=>4800,'8719134015393'=>11300,'8719134015454'=>9700,'8719134016017'=>8700]);//
$promociones[2]= new Promocion("Pack Equilibrio Total","003",['8716716054870'=>11300,'8719134001631'=>4700,'8719134046496'=>8600]);
$promociones[3]= new Promocion("Pack Purificación Total","004",['8716716054559'=>4800,'8716716054580'=>9700,'8716716054658'=>8700,'8719134020991'=>11300]);
$promociones[4]= new Promocion("Pack Renovación Inicial","005",['8716716044567'=>4800,'8716716044796'=>8700]);
$promociones[5]= new Promocion("Pack Renovación Floral","006",['8719134012897'=>9600,'8719134020854'=>11300]);
$promociones[6]= new Promocion("Pack Felicidad Primer Paso","007",['8719134015355'=>4800,'8719134016017'=>8700]);
$promociones[7]= new Promocion("Pack Felicidad Corporal","008",['8719134015393'=>11200,'8719134015454'=>9700]);
$promociones[8]= new Promocion("Pack Armonia","009",['8719134001631'=>4800,'8719134046496'=>8700]);
$promociones[9]= new Promocion("Pack Purificacion al amanecer","010",['8716716054559'=>4800,'8716716054658'=>8700]);
$promociones[10]= new Promocion("Pack Purificación Diaria","011",['8716716054580'=>9700,'8719134020991'=>11200]);
$promociones[11]= new Promocion("Rostro Radiante","012",['3380810232370'=>11700,'3380810232486'=>11800]);
$promociones[12]= new Promocion("Juventud Fresca y masculina","013",['3380810288094'=>16000,'3380810040159'=>19500]);
$promociones[13]= new Promocion("Juventud Sana y masculina","014",['3380810232370'=>11900,'3380810040159'=>19500]);
$promociones[14]= new Promocion("Siempre Joven","015",['3380810194821'=>45600,'3380810272079'=>31900]);
$promociones[15]= new Promocion("Hidratación Total","016",['3380810033830'=>16000,'3380810032871'=>11800]);
$promociones[16]= new Promocion("Rostro Sensible","017",['3380811183107'=>14600,'3380810220742'=>18900]);
$promociones[17]= new Promocion("","0018",['3349666007921'=>50989,'3349668581993'=>1]);
$promociones[18]= new Promocion("","0019",['3349668566372'=>72989,'3349668581993'=>1]);
$promociones[19]= new Promocion("","0020",['3349668579839'=>55989,'3349668581993'=>1]);
$promociones[20]= new Promocion("","0021",['3349668581948'=>81989,'3349668581993'=>1]);
$promociones[21]= new Promocion("","0022",['3349668571970'=>57989,'3349668572113'=>1]);
$promociones[22]= new Promocion("","0023",['3349668515660'=>50989,'3349668579624'=>1]);
$promociones[23]= new Promocion("","0024",['3349668576111'=>50989,'3349668579624'=>1]);
$promociones[24]= new Promocion("","0025",['3349668545728'=>49989,'3349668579907'=>1]);
$promociones[25]= new Promocion("","0026",['8411061975732'=>54989,'8411061980569'=>1]);
$promociones[26]= new Promocion("","0027",['8411061975749'=>64989,'8411061980545'=>1]);
$promociones[27]= new Promocion("","0028",['8411061923245'=>55989,'8411061980507'=>1]);
$promociones[28]= new Promocion("","0029",['8411061777176'=>58989,'8411061975886'=>1]);
$promociones[29]= new Promocion("","0030",['8411061970959'=>59989,'8411061975886'=>1]);
$promociones[30]= new Promocion("","0031",['3137370325949'=>55989,'3137370350019'=>1]);
$promociones[31]= new Promocion("","0032",['8435415000987'=>55989,'8435415033855'=>1]);
$promociones[32]= new Promocion("","0033",['8435415012027'=>54989,'8435415033855'=>1]);
$promociones[33]= new Promocion("","0035",['8411061970935'=>46900,'8411061970959'=>52900]);
$promociones[34]= new Promocion("","0036",['8411061975732'=>49500,'8411061975749'=>58400]);
$promociones[35]= new Promocion("","0037",['3349668545636'=>52200,'3349668545728'=>44700]);
$promociones[36]= new Promocion("","0038",['8034097959899'=>39000,'8052086372979'=>37900]);
$promociones[37]= new Promocion("","0039",['8034097959721'=>47700,'8052086371804'=>38200]);
$promociones[38]= new Promocion("","0040",['3423473020233'=>50900,'3423473020516'=>42000]);
$promociones[39]= new Promocion("","0041",['3423478409552'=>36990,'3423474841554'=>49000]);
$promociones[40]= new Promocion("","0042",['3614272225664'=>35000,'3614272225701'=>35000]);
$promociones[41]= new Promocion("","0043",['3605972130440'=>15000,'3605975062489'=>15000]);
$promociones[42]= new Promocion("","0044",['8411061851500'=>32500,'8411061857755'=>32500]);
$promociones[43]= new Promocion("","0081",['8411061026243'=>66989,'8411061980545'=>1]);
$promociones[44]= new Promocion("","0082",['8410225543794'=>14989,'8410225546672'=>1]);
$promociones[45]= new Promocion("","0083",['8410225524588'=>14989,'8410225546672'=>1]);
$promociones[46]= new Promocion("","0084",['3349668545667'=>45989,'3349668579891'=>1]);
$promociones[47]= new Promocion("","0085",['3349668545636'=>57989,'3349668579891'=>1]);
$promociones[48]= new Promocion("","0086",['3349668562732'=>45989,'3349668579891'=>1]);
$promociones[49]= new Promocion("","0087",['3349668562640'=>57989,'3349668579891'=>1]);
$promociones[50]= new Promocion("","0088",['8411061907580'=>52989,'8411061980545'=>1]);
$promociones[51]= new Promocion("","0089",['8411061777183'=>46989,'8411061980545'=>1]);
$promociones[52]= new Promocion("","0090",['8411061777176'=>68989,'8411061980545'=>1]);
$promociones[53]= new Promocion("","0091",['8011003839117'=>68989,'8011003846511'=>1]);
$promociones[54]= new Promocion("","0092",['8011003823536'=>69989,'8011003846504'=>1]);
$promociones[55]= new Promocion("","0093",['8011003823529'=>51989,'8011003846504'=>1]);
$promociones[56]= new Promocion("","0094",['8011003817498'=>91989,'8011003846504'=>1]);
$promociones[57]= new Promocion("","0095",['8011003993826'=>51989,'8011003846504'=>1]);
$promociones[58]= new Promocion("","0096",['8011003838066'=>47989,'8011003846191'=>1]);
$promociones[59]= new Promocion("","0097",['8011003826711'=>47989,'8011003846191'=>1]);
$promociones[60]= new Promocion("","0098",['8011003826704'=>35989,'8011003846191'=>1]);
$promociones[61]= new Promocion("","0099",['8011003991617'=>42989,'8011003846191'=>1]);
$promociones[62]= new Promocion("","0100",['3423473021377'=>55000,'3423478452657'=>55000]);
$promociones[63]= new Promocion("","0101",['3614223009190'=>37495,'3614223162925'=>37495]);
$promociones[64]= new Promocion("","0102",['3614228228749'=>38495,'3614225296536'=>38495]);
$promociones[65]= new Promocion("","0103",['3360373063703'=>15995,'3360374507206'=>15995]);
$promociones[66]= new Promocion("","0104",['3614271992895'=>39995,'3614271697011'=>39995]);
$promociones[67]= new Promocion("","0105",['3614272889491'=>44995,'3614272889590'=>44995]);
$promociones[68]= new Promocion("","0106",['3605520680014'=>16995,'3605521869807'=>16995]);
?>