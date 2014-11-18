<?php
if(isset($_REQUEST['ploly'])){
	$eq = $_REQUEST['ploly'];
	$a = $_REQUEST['a'];
	$b = $_REQUEST['b'];
	$accuracy = $_REQUEST['accuracy'];
	echo 'Answer is: '.bisection($eq,(double)$a,(double)$b,(double)$accuracy);
}
else{
	?>
<form>
	Polynominal (Ex. x^3-x-2 or 3x^3+x^2-1  without space):<br>
	<input type="text" name="ploly">
	<br>
	Lower endpoin valud:<br>
	<input type="text" name="a">
	<br>
	Greater endpoin valud:<br>
	<input type="text" name="b">
	<br>
	Accuracy (Ex. 0.000001):<br>
	<input type="text" name="accuracy">
	<br><br>
	<input type="submit" value="Submit">
</form>
	<?php
}
/**
 * Placement in polynomial with given x
 * @param  string $polynomial polynomial string
 * @param  int $x          amount of
 * @return int             answer
 */
function poly($polynomial,$x){
	$exp = '';
	$result = 0;
	$first_exp = true;
	for($i=0;$i<strlen($polynomial) ;$i++) {
		$exp[] = $polynomial[$i];
	//	echo $polynomial[$i];
		$x_temp = $x;
		$mul = 1;

	//	echo $polynomial[$i].'   '.$i.'   '.strlen($polynomial)."\n";
		if(@$polynomial[$i+1]=='+' || @$polynomial[$i+1]=='-' || strlen($polynomial)==$i+1) { //each exp seperated by +/-
	//		print_r($exp);
	//		
			//finding mul
			if(is_numeric($exp[1]) && array_search('x', $exp) ){ //If first character of exp is numeric
				$mul = $exp[1];										//And have x
			}
			else if(is_numeric($exp[1])){ //If don't have x
				$x_temp = $exp[1];
			}
			else if($first_exp && is_numeric($exp[0]) ){ //If this is first exp
				$mul = $exp[0];
			}
			if($index_pow = array_search('^', $exp)) { //have pow
				$x_temp = pow((double)$x, (int)$exp[$index_pow+1] );
			}
	//		echo $mul;
	//		echo $x_temp; //answer of x^n
			$result_temp = $mul*$x_temp;
			if(!$first_exp){
				$op = $exp[0];   //get operation between exp
				$result_arr[] = $op.$result_temp;
				// if($op=='+')
				// 	$result += $result_temp;
				// else if($op == '-')
				// 	$result -= $result_temp;
				// echo "result_temp ".$result_temp.'   result='.$result."   op=$op"."\n";
			}
			else {
				$result_arr[] = $result_temp;
			}
		$first_exp = false;
			$exp ='';
		}
	}
	while($key = array_pop($result_arr)){
		if($key[0]=='+' || $key[0]=='-'){ //If this is not last
			$op = $key[0]; //Get operand
			$num = trim($key,'+-');
			if($op=='+')
				$result += $num;
			else if($op == '-')
				$result -= $num;
		}
		else{
				$result += $key;
		}
		if($result != 0){

		}
	}
	return $result;
}


/**
 * bisection method x<y
 * @param  string $eq polynominal
 * @param  int $x first number
 * @param  int $y second number
 * @param  int $accuracy accuracy of Answer
 * @return int    Answer
 */
function bisection($eq,$x,$y,$accuracy){
	if( poly($eq,$x)*poly($eq,$y) < 0 ){
		$n = 1;
		while ($n < 10000) { // to prevent infinitive loop
			 $c = ($x + $y)/2 ;// new midpoint
			 echo 'repeat:'.$n.'   x:'.$x.'  y:'.$y.'  c:'.$c.'  poly:'.poly($eq,$c)."<br>";
			 if(poly($eq,$c) == 0 || ($y-$x)<$accuracy){ // solution found
			    return $c;
			}
			  $n = $n+1; // increment step counter
			  if(poly($eq,$c)*poly($eq,$x)>0)
			  	$x = $c;
			  else
			  	$y = $c;
		}
		echo "Method failed.";

	}
	else{
		echo "Sorry this polynomial don't have answer";
	}
}