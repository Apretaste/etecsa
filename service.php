<?php
use Phalcon\Db\Adapter\Pdo\Sqlite;


class Etecsa extends Service
{
	/**
	 * Function executed when the service is called
	 * 
	 * @param Request
	 * @return Response
	 * @author cjamdeveloper
	 * */


	public function _main(Request $request)
		{
		// do not allow blank searches
			if(empty($request->query))
			{
				$response = new Response();
				$response->setCache();
				$response->setResponseSubject("Que numero desea buscar en etecsa?");
				$response->setCache("year");
				$response->createFromTemplate("home.tpl", array());
				return $response;
			}

			$arrayResultQuery = "";
			$countResult = 0; 
		
			$codProv = substr($request->query, 0,strlen($request->query)-6  );
			$numberOnly = ""; 
			$isphoneHavana = false;

			
			
			if (substr($request->query, 0, 1) ==7) {
				$numberOnly = substr($request->query, 1);
				$isphoneHavana = true;
			}else if (strlen($request->query) ==8) {
				$numberOnly = substr($request->query, 2);
			}else{
				$codProv = 0;
				$numberOnly = 0;
			}

	
			/*Connection and Query*/
			$connection = new Sqlite(["dbname" => "download/Etecsa.db",]);
			if ($isphoneHavana) {
				$queryfix =   $connection->fetchOne("SELECT * FROM fix WHERE number = ".$numberOnly);
			}else{
				$queryfix =   $connection->fetchOne("SELECT * FROM fix WHERE number = ".$numberOnly." AND province =  ".$codProv);
			}
			
			$querymovil = $connection->fetchOne("SELECT * FROM movil WHERE number = ".$request->query);


			/*Check if have result*/
			if ($queryfix!="" ) {
				$arrayResultQuery = $queryfix;
				$countResult = 1;
			}else if($querymovil!=""){
				$arrayResultQuery = $querymovil;
				$countResult = 1;
			}else{
				$countResult = 0;
				$arrayResultQuery = array('name' => '','address'=>'' ,'province'=>'');
			}


			$responseContent = array(
			"name" => $arrayResultQuery['name'],
			'query' =>$request->query,
			"address" => $arrayResultQuery['address'],
			'province' =>$this->getProvinceByNumber($arrayResultQuery['province']),
			"result_count" => $countResult

		
			);

		

			$response = new Response();
			$response->setCache("month");
			$response->createFromTemplate("basic.tpl", $responseContent);
			return $response;
		}

	public function getProvinceByNumber($numberprovince)
	{
		$province = "";
		switch ($numberprovince) {
			case 7:
				$province = "LA HABANA";
				break;
			case 21:
				$province = "GUANTANAMO";
				break;	
			case 22:
				$province = "SANTIAGO DE CUBA";
				break;	

			case 23:
				$province = "GRANMA";
				break;	
			case 24:
				$province = "HOLGUIN";
				break;
			case 31:
				$province = "LAS TUNAS";
				break;	
						
			case 32:
				$province = "CAMAGUEY";
				break;	

			case 33:
				$province = "CIEGO DE AVILA";
				break;	

			case 41:
				$province = "SANCTI SPIRITUS";
				break;	

			case 42:
				$province = "VILLA CLARA";
				break;

			case 43:
				$province = "CIENFUEGOS";
				break;

			case 45:
				$province = "MATANZAS";
				break;		

			case 46:
				$province = "ISLA DE LA JUVENTUD";
				break;	
			case 47:
				$province = "ARTEMISA o MAYABEQUE";
				break;	
			case 48:
				$province = "PINAR DEL RIO";
				break;	

			
			
		}

		return $province;
	}

	public function _codigos()
	{
		$array = array('title' => 'codigos' );
		$response = new Response();
		$response->createFromTemplate("codigos.tpl",$array);
		return $response;
	}

	public function _testExistDb()
	{
		$result = "";
		if (file_exists('download/Etecsa.db') || file_exists('download/etecsa.db') ) {
			echo "Si esta la db";
		}else{
			echo "Falta la db";
		}

		$array = array('title' => 'codigos' );
		$response = new Response();
		$response->createFromText();
	}
}
