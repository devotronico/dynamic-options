<?php




if (!isset($_GET)) { header("Location: index.php"); die; }

header('Content-Type: application/json;charset=utf-8');



if (!filter_has_var(INPUT_GET, "query")) { die('{"status": "error", "error": "http", "message": "variabile POST con indice signup non trovata"}'); }

$query = $_GET["query"];



$conn = new mysqli('localhost', 'root', '', 'db_gestionale');

if ($conn->connect_error) {
    die('Errore di connessione (' . $conn->connect_errno . ') '
    . $conn->connect_error);
}
// require '../conn.php';



// FUNZIONA (non cancellare)
// $sql = "SELECT temp.id AS `documentoId`, temp.importo AS `documentoImporto`, temp.data, C.nome AS nomeCliente, F.nome AS nomeFornitore, P.tipo FROM (
//         SELECT `cliente_id`, `fornitore_id`, `pagamento_id`, `data`, `importo` FROM `fatture`
//         UNION ALL
//         SELECT `cliente_id`, `fornitore_id`, `pagamento_id`, `data`, `importo` FROM `notecredito`
//         UNION ALL
//         SELECT `cliente_id`, `fornitore_id`, `pagamento_id`, `data`, `importo`  FROM `parcelle`
//       ) AS `temp`
//       LEFT JOIN `clienti` AS `C` ON temp.cliente_id = C.id
//       LEFT JOIN `fornitori` AS `F` ON temp.fornitore_id = F.id
//       JOIN `pagamenti` AS `P` ON temp.pagamento_id = P.id
//       WHERE temp.pagamento_id = 2 AND YEAR(temp.data) BETWEEN 1990 AND 2019
//       ORDER BY temp.data DESC";

// die('{"status": "test", "test": "'.$query.'"}');
switch ($query) {
  case 'clienti':
    $sql = "SELECT `id`, `nome` AS `text` FROM `clienti`";
    break;
  case 'fornitori':
    $sql = "SELECT `id`, `nome` AS `text` FROM `fornitori`";
    break;
  case 'fatture':
    $sql = "SELECT `id`, `importo` AS `text` FROM `fatture`";
    break;
  case 'notecredito':
    $sql = "SELECT `id`, `importo` AS `text` FROM `notecredito`";
    break;
  case 'parcelle':
    $sql = "SELECT `id`, `importo` AS `text` FROM `parcelle`";
    break;
  case 'document':
  $sql = "SELECT temp.importo, temp.data, C.nome AS nomeCliente, F.nome AS nomeFornitore, P.id AS 'id', P.tipo AS 'text' FROM (
    SELECT `cliente_id`, `fornitore_id`, `pagamento_id`, `data`, `importo` FROM `fatture`
    UNION ALL
    SELECT `cliente_id`, `fornitore_id`, `pagamento_id`, `data`, `importo` FROM `notecredito`
    UNION ALL
    SELECT `cliente_id`, `fornitore_id`, `pagamento_id`, `data`, `importo`  FROM `parcelle`
  ) AS `temp`
  LEFT JOIN `clienti` AS `C` ON temp.cliente_id = C.id
  LEFT JOIN `fornitori` AS `F` ON temp.fornitore_id = F.id
  JOIN `pagamenti` AS `P` ON temp.pagamento_id = P.id
  ORDER BY temp.data DESC";
    break;
  
  default:
    die('{"status": "error", "error": "switch"}');
    break;
}



if (!$result = $conn->query($sql)) { die('{"status": "error", "error": "query"}'); }


$data = [];
while ( $row = $result->fetch_assoc() ) {

  $data[] = ['value' => $row['id'], 'text' => $row['text']];
}

// $data = $result->fetch_all(MYSQLI_ASSOC);

$str = json_encode($data);
// $str = '{"value": "test", "text": "json"}';
die($str);
/*
$result->close();

$conn->close();
*/
// 




//$rows = $result->fetch_assoc();

//$row_count = $result->num_rows;
//echo $row_count;

//$status = explode('  ', $conn->stat());
//echo '<pre>';print_r($status);echo '</pre>';

//echo '<pre>';print_r($rows);echo '</pre>';
?>



