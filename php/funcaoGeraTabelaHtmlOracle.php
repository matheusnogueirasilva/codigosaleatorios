<?php
function geraTabela($query,$formatdata){
    //Conexão com o Banco de Dados Oracle.
    $conn = connect();
    $i = 0;

    //Alteração de formatos de Data e Número.
    $querySession = "ALTER SESSION SET NLS_DATE_FORMAT = '$formatdata'"; //Formato de Data recebida como parâmetro.
    $queryNumero = "ALTER SESSION SET nls_numeric_characters=',.'";
    $stmtNumero = oci_parse($conn,$queryNumero);
    oci_execute($stmtNumero);
    $stmtSession = oci_parse($conn,$querySession);
    oci_execute($stmtSession);

    //Execução da Query recebida como parâmetro.
    $stmt = oci_parse($conn,$query);
    oci_execute($stmt);


    while($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)){
        //Na primeira execução da estrutura de repetição é feita a criação do cabeçalho da tabela,
        //utilizando a nomenclatura das colunas da Query.
        if($i==0){
            ?>
            <div class="table-responsive" id="teste">
                <table class="table table-striped table-hover table-secondary" id="tblExport" name="tblExport">
                    <thead class="bg-primary text-white">
                        <tr>
                            <?php
                            reset($row); 
                            while (list($key, $val) = each($row)) {
                                ?>
                                <th><?php echo $key ;?></th>
                                <?php
                            }
                            $i = 1;
                            ?>
                        </tr>
                    </thead>		
                <tbody>
                <?php
        }
        //Nas demais execuções são criadas as linhas da tabela. 
        reset($row); 
        ?>
        <tr>
        <?php
            while (list($key, $val) = each($row)) {  
                ?>
                <td style="white-space: nowrap;"><?php echo $val ;?></td>
                <?php
            }
            ?>
            </tr>
            <?php
    }
    ?>
    </tbody>
</table>
</div>
<?php
}
?>