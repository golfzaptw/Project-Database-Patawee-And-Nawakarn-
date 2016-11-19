<?php
session_start ();

$p_id = $_REQUEST ['p_id'];
$act = $_REQUEST ['act'];

if ($act == 'add' && ! empty ( $p_id )) {
	if (isset ( $_SESSION ['cart'] [$p_id] )) {
		$_SESSION ['cart'] [$p_id] ++;
	} else {
		$_SESSION ['cart'] [$p_id] = 1;
	}
}

if ($act == 'remove' && ! empty ( $p_id )) // ¡��ԡ�����觫���
{
	unset ( $_SESSION ['cart'] [$p_id] );
}

if ($act == 'update') {
	$amount_array = $_POST ['amount'];
	foreach ( $amount_array as $p_id => $amount ) {
		$_SESSION ['cart'] [$p_id] = $amount;
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shopping Cart</title>
</head>

<body>
	<form id="frmcart" name="frmcart" method="post" action="?act=update">
		<table width="600" border="0" align="center" class="square">
			<tr>
				<td colspan="5" bgcolor="#CCCCCC"><b>�С����Թ���</span></td>
			</tr>
			<tr>
				<td bgcolor="#EAEAEA">�Թ���</td>
				<td align="center" bgcolor="#EAEAEA">�Ҥ�</td>
				<td align="center" bgcolor="#EAEAEA">�ӹǹ</td>
				<td align="center" bgcolor="#EAEAEA">���(�ҷ)</td>
				<td align="center" bgcolor="#EAEAEA">ź</td>
			</tr>
<?php
$total = 0;
if (! empty ( $_SESSION ['cart'] )) {
	include ("connect.inc");
	foreach ( $_SESSION ['cart'] as $p_id => $qty ) {
		$sql = "select * from product where p_id=$p_id";
		$query = mysqli_query ( $conn, $sql );
		$row = mysqli_fetch_array ( $query );
		$sum = $row ['p_price'] * $qty;
		$total += $sum;
		echo "<tr>";
		echo "<td width='334'>" . $row ["p_name"] . "</td>";
		echo "<td width='46' align='right'>" . number_format ( $row ["p_price"], 2 ) . "</td>";
		echo "<td width='57' align='right'>";
		echo "<input type='text' name='amount[$p_id]' value='$qty' size='2'/></td>";
		echo "<td width='93' align='right'>" . number_format ( $sum, 2 ) . "</td>";
		// remove product
		echo "<td width='46' align='center'><a href='cart.php?p_id=$p_id&act=remove'>ź</a></td>";
		echo "</tr>";
	}
	echo "<tr>";
	echo "<td colspan='3' bgcolor='#CEE7FF' align='center'><b>�Ҥ����</b></td>";
	echo "<td align='right' bgcolor='#CEE7FF'>" . "<b>" . number_format ( $total, 2 ) . "</b>" . "</td>";
	echo "<td align='left' bgcolor='#CEE7FF'></td>";
	echo "</tr>";
}
?>
<tr>
				<td><a href="product.php">��Ѻ˹����¡���Թ���</a></td>
				<td colspan="4" align="right"><input type="submit" name="button"
					id="button" value="��Ѻ��ا" /> <input type="button" name="Submit2"
					value="��觫���" onclick="window.location='confirm.php';" /></td>
			</tr>
		</table>
	</form>
</body>
</html>