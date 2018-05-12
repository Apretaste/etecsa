{if {$result_count} != 0}
<h1> Resultados para : {$query}</h1>
{/if}

{if {$result_count} == 0}
   <h1>No  encontramos resultado en Etecsa</h1>

<p>Su busqueda <b>"{$query}"</b> no arrojo resultados , intentelo de nuevo. Si el problema persiste contacte con el soporte tecnico.</p>

<center>
	
	{button caption="Intentar de nuevo" href="ETECSA" desc="n:Inserte el numero a buscar*" popup="true"}
</center>
{/if}

{if {$result_count} == 1}
<h4>Nombre y Apellidos : {$name}</h4>
<h4>Direccion : {$address}</h4>

<h4>Provincia : {$province}</h4>

<center>
	{button caption="Atras" href="ETECSA" wait=false}
</center>
<p ><font color="red">Apretaste no se hace reponsable  del uso que le de a los datos anteriores.</font></p>
{/if}