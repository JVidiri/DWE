<style>
.red{
	color: red;
}
</style>

<?php
if(isset($_POST['sal'])){
  	$salBruto = $_POST['sal'];

  	if ($salBruto < 0 ){
  		//Houston we have a problem...
  		header('Location: '.'?erro=1');
  		die();
  	}

  	//Se o salário for maior que o teto nem faço conta.
  	if ($salBruto >= 5189.82){  		
  		$salSemInss = $salBruto - 570.88;
  		//return $salSemInss;
	}else {
		//tá temos que fazer conta, pelo menos já sabemos que é maior que zero...
  		$alicota = 0.08;
  		//probabilidade de o salário ser maior que a faixa do meio is too damm high....
		if ($salBruto >= 2594.93){
			$alicota = 0.11;		
		}elseif ($salBruto >= 1556.95){
			//worst case for us o cara está na faixa do meio...
			$alicota = 0.09;
		}
		//Calculando o valor do salário descontado inss, baseado na Alíquota...
		$salSemInss = ($salBruto - ($salBruto * $alicota));
		//return $salSemInss;
	}

	//Se não cair em uma das alicotas é sinal de que ele é isento.
  	$salLiqui = $salSemInss;
  	if (($salSemInss >= 1903.99) and ($salSemInss <= 2826.65)){
  		//temos que calcular a segunda alicota e tirar o desconto...
  		$salLiqui = $salSemInss - (($salSemInss * 0.075) -  142.80);
  	}elseif (($salSemInss >= 2826.66) and ($salSemInss <= 3751.05)){
		$salLiqui = $salSemInss - (($salSemInss * 0.15) -  354.80);
  	}elseif (($salSemInss >= 3751.06) and ($salSemInss <= 4664.68)){
		$salLiqui = $salSemInss - (($salSemInss * 0.225) -  636.13);
  	}elseif ($salSemInss >= 4664.68){  		
  		$salLiqui = $salSemInss - (($salSemInss * 0.275) -  869.36);
  	}

  	//echo "$salBruto | $salLiqui | $salSemInss";
}
  
?>
<html>
<head>
	<title>Calculador descontos</title>
	<meta charset="UTF-8">
</head>
<body>
	<?php 
	if(isset($_POST['sal'])){ ?>
	<table>
		<tr>
			<td>Salário Bruto:</td>
			<td><?php echo $salBruto ?></td>
		</tr>	
		<tr>
			<td>Salário Salário com desconto INSS:</td>
			<td><?php echo $salSemInss ?></td>
		</tr>
		<tr>
			<td>Salário Liquido:</td>
			<td><?php echo $salLiqui ?></td>
		</tr>
	</table>
	<?php } ?>
	<?php 
	if(isset($_GET['erro'])){
		switch ($_GET['erro']) {
			case '1':
				echo '<p class="red">Por favor digite um salário válido...</p>';
			break;
		}
	}
	?>
	<form action="calculo.php" method="post">
	<p>Salário bruto:</p>
	<p><input type="number" name="sal" value="sal" id="sal"/></p>
	<p><input type="submit" value="Calcular"/></p>
</body>
</html>