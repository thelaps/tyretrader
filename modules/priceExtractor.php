<?php
class priceExtractor extends connector{

    private $dbo;

    private $companyId = null;
    private $currency = 'UAH';
    private $currencyRate = null;

    const DEFAULT_CURRENCY = 2;

    public function DBOExtract($priceData){
        $this->dbo=App::DBO();
        $total = sizeof($priceData);
        $status = false;
        $price = null;
        if($total>0){
            if(!empty($priceData[0]->company)){
                $currencyRate = $this->getModel('wheel_currencyRate');
                $this->currencyRate = $currencyRate->getIsoMargins();

                $this->companyId = $priceData[0]->company;



                $company = $this->getModel('wheel_companies');
                $company->setId($this->companyId);
                $companyData = $company->getCompanies(true);

                if ( $companyData != null ) {
                    if ( $companyData->iso != null && $companyData->rate > 0 ) {
                        $this->currencyRate[$companyData->iso] = $companyData->rate;
                        $this->currency = $companyData->iso;
                    }
                }

                $currentPrice = $this->extractPriceByCompany($this->companyId);
                $currentPrice = array();
                $priceAction = new stdClass();
                $priceAction->insert = array();
                $priceAction->update = array();
                for($i=0; $i<$total; $i++){
                    $this->addRowToPriceAction($this->companyId,$priceData[$i],$currentPrice,$priceAction);
                }

                if($this->makeSqlProcess($priceAction)){
                    $price = $this->getPriceData($this->companyId);
                    $status = true;
                }
            }
        }

        return array('status'=>$status, 'price'=>$price);
    }

    public function syncPrices(){
        return $this->syncView();
    }

    private function makeSqlProcess($priceAction){
        $cleanup = 'TRUNCATE TABLE wheel_price_com'.$this->companyId;
        $this->runQuery($cleanup);

        if(sizeof($priceAction->insert)>0){
            $sqlInsert = $this->extractInsert($priceAction->insert);
            $insertTotal = sizeof($sqlInsert);
            for($i=0; $i<$insertTotal; $i++){
                $this->runQuery($sqlInsert[$i]);
            }
        }
        if(sizeof($priceAction->update)>0){
            $sqlUpdate = $this->extractUpdate($priceAction->update);
            $updateTotal = sizeof($sqlUpdate);
            for($i=0; $i<$updateTotal; $i++){
                $this->runQuery($sqlUpdate[$i]);
            }
        }
        return true;
    }

    private function runQuery($query){
        $dbo=$this->dbo;
        $stmt = $dbo->prepare($query);
        return $stmt->execute();
    }

    private function extractUpdate($priceAction){
        $sqlUpdate = '';
        $sqlUpdateArray = array();
        $total = sizeof($priceAction);
        $counter = 0;
        for($i=0; $i<$total; $i++){
            $this->modifyPricing($priceAction[$i]);
            $sqlUpdate .= 'UPDATE wheel_price_com'.$this->companyId.' ';
            $sqlUpdate .= $this->getFields($priceAction[$i]);
            $sqlUpdate .= ' WHERE model_id='.$priceAction[$i]['model_id'].'; ';
            $sqlUpdateArray[]=$sqlUpdate;
            $counter++;
        }
        return $sqlUpdateArray;
    }

    private function getFields($row){
        $fields = array();
        foreach($row as $key=>$val){
            $fields[] = $key.'='.$val;
        }
        $setQuery = 'SET '.implode(', ',$fields);
        return $setQuery;
    }

    private function extractInsert($priceAction){
        $sqlInsert = '';
        $sqlInsertArray = array();
        $total = sizeof($priceAction);
        $keys = implode(', ', array_keys($priceAction[0]));
        for($i=0; $i<$total; $i++){
            if($i==0 || $i%10==0){
                $sqlInsert = 'INSERT INTO wheel_price_com'.$this->companyId.' ';
            }
            $sqlInsert .= ($i==0 || $i%10==0)?'('.$keys.') VALUES ':',';
            $priceAction[$i]['company_id'] = $this->companyId;
            $this->modifyPricing($priceAction[$i]);
            $sqlInsert .= '('.implode(', ', $priceAction[$i]).')';
            if(($i+1)%10==0 || $i==$total-1){
                $sqlInsert .= '; ';
                $sqlInsertArray[] = $sqlInsert;
            }
        }
        return $sqlInsertArray;
    }

    private function modifyPricing(&$priceAction){
        for($i=1; $i<5; $i++){
            $priceAction['price_'.$i] = ($priceAction['price_'.$i] instanceof stdClass)?
                $this->recountCurrency($priceAction['price_'.$i]):'NULL';
        }
        return true;
    }

    private function recountCurrency($stdPrice){
        $summary = $stdPrice->price;

        $strPrice = ($summary>0)?$summary:'NULL';

        return '\''.$strPrice.'\'';
    }

    private function recountInlineCurrency($rawPrice){
        $summary = 0.00;
        if($rawPrice!='NULL'){
            if(!empty($rawPrice->price)){
                if($this->currency!='UAH'){
                    $rate = $this->currencyRate[$this->currency];
                    $summary = (float)$rawPrice->price * (float)$rate;
                    $rawPrice->price = $summary;
                }
            }
        }

        return $rawPrice;
    }

    /*
     * бренд
     * модель
     * наименование
     * сезон
     * применение
     * ширина
     * высота
     * диаметр
     * ...
     */

    private function addRowToPriceAction($company_id,$row,$currentPrice,&$priceAction){
        if(sizeof($row)>0){
            $modelManufacturer = $this->extractParameter($row->required,1);
            if(isset($modelManufacturer->id)){
                if(!empty($row->currency)){
                    $this->currency = $row->currency;
                }else{
                    $this->currency = 'UAH';
                }
                $struct = array(
                    'price_1' => $this->recountInlineCurrency($this->extractParameter($row->parameters,21)),
                    'price_2' => $this->recountInlineCurrency($this->extractParameter($row->parameters,22)),
                    'price_3' => $this->recountInlineCurrency($this->extractParameter($row->parameters,23)),
                    'price_4' => $this->recountInlineCurrency($this->extractParameter($row->parameters,24)),
                    'stock_1' => $this->extractParameter($row->parameters,25),
                    'stock_2' => $this->extractParameter($row->parameters,26),
                    'stock_3' => $this->extractParameter($row->parameters,27),
                    'spike' => $this->extractParameter($row->parameters,33),
                    'color' => $this->extractParameter($row->parameters,16),
                    'technology' => $this->extractParameter($row->parameters,32),
                    'marking' => $this->extractParameter($row->parameters,39),
                    'manufacturer_id' => (isset($modelManufacturer->manufacturer_id))?$modelManufacturer->manufacturer_id:$row->manufacturer,
                    'model_id' => $modelManufacturer->id,
                    'artnum' => $this->extractParameter($row->parameters,5),
                    'company_id' => $company_id,
                    'date' => time(),
                    'size_r'=>(!empty($row->R))?$row->R:'NULL',
                    'size_w'=>(!empty($row->W))?$row->W:'NULL',
                    'size_h'=>(!empty($row->H))?$row->H:'NULL',
                    'size_i'=>'\''.$row->I.'\'',
                    'si_f'=>'\''.$row->Si->F.'\'',
                    'si_b'=>'\''.$row->Si->B.'\'',
                    'sw_f'=>'\''.$row->Sw->F.'\'',
                    'sw_b'=>'\''.$row->Sw->B.'\'',
                    'et' => $this->extractParameter($row->parameters,11),
                    'dia' => $this->extractParameter($row->parameters,14),
                    'pcd_1' => $this->extractParameter($row->parameters,9),
                    'pcd_2' => $this->extractParameter($row->parameters,10),
                    'bolt' => $this->extractParameter($row->parameters,15),
                    'manufactured_country' => $this->extractMCountry($row->parameters),
                    'manufactured_year' => $this->extractMYear($row->parameters),
                );

                if(in_array($modelManufacturer->id, $currentPrice)){
                    array_push($priceAction->update,$struct);
                    return true;
                }else{
                    array_push($priceAction->insert,$struct);
                    return true;
                }
            }
        }
        return false;
    }

    private function extractMCountry($parameters){
        $_simpleValue = $this->extractParameter($parameters,20);
        $_mixedValue = $this->extractParameter($parameters,44);
        return ($_mixedValue != 'NULL' && !empty($_mixedValue->country)) ? $_mixedValue->country : $_simpleValue;
    }

    private function extractMYear($parameters){
        $_simpleValue = $this->extractParameter($parameters,43);
        $_mixedValue = $this->extractParameter($parameters,44);
        return $this->prepareYear(($_mixedValue != 'NULL' && !empty($_mixedValue->year)) ? $_mixedValue->year : $_simpleValue, true);
    }

    private function extractParameter($parameters,$needle,$alias = null){
        foreach($parameters as $parameter){
            if($parameter->parameter_id==$needle && $parameter->value!=null){
                return ($this->is_int($parameter->value) || is_object($parameter->value))?$parameter->value:((!empty($parameter->value))?'\''.$parameter->value.'\'':'NULL');
            }
        }
        return ($this->is_int($alias) || is_object($alias))?$alias:((!empty($alias))?'\''.$alias.'\'':'NULL');

    }

    private function prepareYear($rawYear = null, $allowEmpty = false){
        if ( $rawYear != null ) {
            $intYear = filter_var($rawYear, FILTER_SANITIZE_NUMBER_INT);
            if ( strlen((string)$intYear) == 2 ) {
                return date('Y', strtotime(date($intYear.'-m-d')));
            } else {
                return (empty($intYear)) ? (($allowEmpty) ? 'NULL' : '-') : $intYear;
            }
        }
        return (($allowEmpty) ? 'NULL' : '-');
    }

    private function is_int($data){
        if(!is_object($data)){
            return preg_match('/^([0-9]+)$/',$data, $match);
        }
        return false;
    }

    private function getPriceData($company_id){
        $viewData=new stdClass();
        $viewData->wheel = array();
        $viewData->tyre = array();
        $dbo=$this->dbo;
        $query='SELECT wheel_price_com'.$company_id.'.*, wheel_manufacturers.name AS manufacturer,
            wheel_models.name AS model,
            wheel_models.src,
            wheel_models.season, wheel_models.use,
            wheel_models.type_transport, wheel_models.axle,
            wheel_manufacturers2type.type as manufacturer_type,
            wheel_manufacturers2type.wheel_type as manufacturer_wheel_type
            FROM wheel_price_com'.$company_id.'
            LEFT JOIN wheel_manufacturers
            ON wheel_manufacturers.id=manufacturer_id
            LEFT JOIN wheel_manufacturers2type ON wheel_manufacturers.id=wheel_manufacturers2type.manufacturer_id
            LEFT JOIN wheel_models ON wheel_models.id=model_id';
            /*'WHERE date=(SELECT MAX(date) FROM wheel_price_com'.$company_id.')'*/
            $query .= ' GROUP BY wheel_price_com'.$company_id.'.id';
            $query .= ' ORDER BY manufacturer ASC, model ASC, size_w ASC, size_h ASC, size_r ASC';
        $stmt = $dbo->prepare($query);
        if($stmt->execute()){
            while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                switch ($row->manufacturer_type) {
                    case 1:
                        $viewData->tyre[] = $row;
                        break;
                    case 2:
                        $viewData->wheel[] = $row;
                        break;
                }
            }
        }

        return $viewData;
    }

    private function extractPriceByCompany($company_id){
        $viewData=array();
        $dbo=$this->dbo;
        $query='SELECT model_id FROM wheel_price_com'.$company_id;
        $stmt = $dbo->prepare($query);

        if($stmt->execute()){
            while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                $viewData[]=$row->model_id;
            }
        }else{
            $query='
            CREATE TABLE IF NOT EXISTS `wheel_price_com'.$company_id.'` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `price_1` float NOT NULL,
              `price_2` float DEFAULT NULL,
              `price_3` float DEFAULT NULL,
              `price_4` float DEFAULT NULL,
              `stock_1` int(5) NOT NULL,
              `stock_2` int(5) DEFAULT NULL,
              `stock_3` int(5) DEFAULT NULL,
              `manufacturer_id` int(11) NOT NULL,
              `model_id` int(11) NOT NULL,
              `artnum` varchar(32) DEFAULT NULL,
              `img` varchar(255) DEFAULT NULL,
              `company_id` int(11) NOT NULL,
              `date` int(11) NOT NULL,
              `size_r` float DEFAULT NULL,
              `size_w` float DEFAULT NULL,
              `size_h` float DEFAULT NULL,
              `size_i` varchar(4) DEFAULT NULL,
              `si_f` varchar(4) DEFAULT NULL,
              `si_b` varchar(4) DEFAULT NULL,
              `sw_f` varchar(4) DEFAULT NULL,
              `sw_b` varchar(4) DEFAULT NULL,
              `spike` int(4) DEFAULT NULL,
              `color` int(4) DEFAULT NULL,
              `technology` int(4) DEFAULT NULL,
              `marking` int(4) DEFAULT NULL,
              `et` float DEFAULT NULL,
              `dia` float DEFAULT NULL,
              `pcd_1` int(3) NOT NULL,
              `pcd_2` int(3) NOT NULL,
              `bolt` int(3) NOT NULL,
              `manufactured_country` int(3) DEFAULT NULL,
              `manufactured_year` varchar(12) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';

            $stmt = $dbo->prepare($query);
            if($stmt->execute()){
                $this->syncView();
                $viewData = $this->extractPriceByCompany($company_id);
            }
        }
        return $viewData;
    }

    private function syncView()
    {
        $scopeTables = array();
        $dbo=App::DBO();
        $query='SHOW TABLES WHERE `Tables_in_wheels` LIKE \'wheel_price_com%\'';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $scopeTables[] = $row['Tables_in_wheels'];
        }
        if(!empty($scopeTables)){
            $unionsSql = '
                CREATE OR REPLACE VIEW wheel_priceview AS SELECT `wheel_price`.*, wheel_manufacturers.name AS manufacturer,
                wheel_models.name AS model,
                wheel_models.src,
                wheel_models.season, wheel_models.use,
                wheel_models.type_transport, wheel_models.axle,
                wheel_manufacturers2type.type as manufacturer_type,
                wheel_manufacturers2type.wheel_type as manufacturer_wheel_type
                FROM `wheel_price`
                LEFT JOIN wheel_manufacturers
                ON wheel_manufacturers.id=manufacturer_id
                LEFT JOIN wheel_manufacturers2type ON wheel_manufacturers.id=wheel_manufacturers2type.manufacturer_id
                LEFT JOIN wheel_models ON wheel_models.id=model_id';
            foreach ($scopeTables as $table){
                $unionsSql .= ' UNION SELECT `'.$table.'`.*, wheel_manufacturers.name AS manufacturer,
                    wheel_models.name AS model,
                    wheel_models.src,
                    wheel_models.season, wheel_models.use,
                    wheel_models.type_transport, wheel_models.axle,
                    wheel_manufacturers2type.type as manufacturer_type,
                    wheel_manufacturers2type.wheel_type as manufacturer_wheel_type
                    FROM `'.$table.'`
                    LEFT JOIN wheel_manufacturers
                    ON wheel_manufacturers.id=manufacturer_id
                    LEFT JOIN wheel_manufacturers2type ON wheel_manufacturers.id=wheel_manufacturers2type.manufacturer_id
                    LEFT JOIN wheel_models ON wheel_models.id=model_id';
            }
            $stmt = $dbo->prepare($unionsSql);
            return $stmt->execute();
        }
        return false;
    }

}
//Price table
// ID , PRICE1, PRICE2, PRICE3, PRICE4, STOCK1, STOCK2, STOCK3,
// MANUFACTURER_ID, MODEL_ID, ARTNUM, IMG, COMPANY_ID, date
/*
Array
(
    [0] => Array
        (
            [currency] => 2
            [existing] =>
            [R] => 13
            [W] => 175
            [H] => 70
            [I] =>
            [type] => 0
            [manufacturer] => 0
            [model] =>
            [Si] => Array
                (
                    [F] =>
                    [B] => T
                )

            [Sw] => Array
                (
                    [F] =>
                    [B] => 82
                )

            [parameters] => Array
                (
                    [0] => Array
                        (
                            [parameter_id] => 8
                            [value] => 175/70R13
                        )

                    [1] => Array
                        (
                            [parameter_id] =>
                            [value] =>
                        )

                    [2] => Array
                        (
                            [parameter_id] => 16
                            [value] => 54
                        )

                    [3] => Array
                        (
                            [parameter_id] => 32
                            [value] =>
                        )

                    [4] => Array
                        (
                            [parameter_id] => 32
                            [value] =>
                        )

                    [5] => Array
                        (
                            [parameter_id] => 39
                            [value] =>
                        )

                    [6] => Array
                        (
                            [parameter_id] => 21
                            [value] => Array
                                (
                                    [price] => 310.00
                                    [currency] =>
                                )

                        )

                    [7] => Array
                        (
                            [parameter_id] => 25
                            [value] => 8
                        )

                )

            [required] => Array
                (
                    [0] => Array
                        (
                            [parameter_id] => 4
                            [value] => Barum
                        )

                    [1] => Array
                        (
                            [parameter_id] => 1
                            [value] => Array
                                (
                                    [id] => 2288
                                    [model] => Brillantis
                                    [manufacturer_id] => 12
                                    [manufacturer] => Barum
                                    [alias] =>
                                )

                        )

                )

            [raw] => 175/70R13 | Barum | | 175/70R13 Barum Brillantis 2 82T Bleck | 310 | 8
        )

    [1] => Array
        (
            [currency] => 2
            [existing] =>
            [R] => 13
            [W] => 175
            [H] => 70
            [I] =>
            [type] => 0
            [manufacturer] => 0
            [model] =>
            [Si] => Array
                (
                    [F] =>
                    [B] => T
                )

            [Sw] => Array
                (
                    [F] =>
                    [B] => 82
                )

            [parameters] => Array
                (
                    [0] => Array
                        (
                            [parameter_id] => 8
                            [value] => 175/70R13
                        )

                    [1] => Array
                        (
                            [parameter_id] =>
                            [value] =>
                        )

                    [2] => Array
                        (
                            [parameter_id] => 16
                            [value] =>
                        )

                    [3] => Array
                        (
                            [parameter_id] => 32
                            [value] =>
                        )

                    [4] => Array
                        (
                            [parameter_id] => 32
                            [value] =>
                        )

                    [5] => Array
                        (
                            [parameter_id] => 39
                            [value] =>
                        )

                    [6] => Array
                        (
                            [parameter_id] => 21
                            [value] => Array
                                (
                                    [price] => 390.00
                                    [currency] =>
                                )

                        )

                    [7] => Array
                        (
                            [parameter_id] => 25
                            [value] => 25
                        )

                )

            [required] => Array
                (
                    [0] => Array
                        (
                            [parameter_id] => 4
                            [value] => BF Goodrich
                        )

                    [1] => Array
                        (
                            [parameter_id] => 1
                            [value] => Array
                                (
                                    [id] => 2233
                                    [model] => Touring
                                    [manufacturer_id] => 13
                                    [manufacturer] => BF Goodrich
                                    [alias] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [model_id] => 2233
                                                    [synonym] => Toureing
                                                    [manufacturer_id] => 13
                                                )

                                        )

                                )

                        )

                )

            [raw] => 175/70R13 | BFGoodrich | | 175/70R13 BFGoodrich Touring 82T | 390 | 25
        )

    [2] => Array
        (
            [currency] => 2
            [existing] =>
            [R] => 13
            [W] => 175
            [H] => 70
            [I] =>
            [type] => 0
            [manufacturer] => 0
            [model] =>
            [Si] => Array
                (
                    [F] =>
                    [B] => T
                )

            [Sw] => Array
                (
                    [F] =>
                    [B] => 82
                )

            [parameters] => Array
                (
                    [0] => Array
                        (
                            [parameter_id] => 8
                            [value] => 175/70R13
                        )

                    [1] => Array
                        (
                            [parameter_id] =>
                            [value] =>
                        )

                    [2] => Array
                        (
                            [parameter_id] => 16
                            [value] =>
                        )

                    [3] => Array
                        (
                            [parameter_id] => 32
                            [value] =>
                        )

                    [4] => Array
                        (
                            [parameter_id] => 32
                            [value] =>
                        )

                    [5] => Array
                        (
                            [parameter_id] => 39
                            [value] =>
                        )

                    [6] => Array
                        (
                            [parameter_id] => 21
                            [value] => Array
                                (
                                    [price] => 390.00
                                    [currency] =>
                                )

                        )

                    [7] => Array
                        (
                            [parameter_id] => 25
                            [value] => 25
                        )

                )

            [required] => Array
                (
                    [0] => Array
                        (
                            [parameter_id] => 4
                            [value] => BF Goodrich
                        )

                    [1] => Array
                        (
                            [parameter_id] => 1
                            [value] => Touring
                        )

                )

            [raw] => 175/70R13 | BF Gudrich | | 175/70R13 BF Gudrich Toureing 82T | 390 | 25
        )

    [3] => Array
        (
            [currency] => 2
            [existing] =>
            [R] => 13
            [W] => 175
            [H] => 70
            [I] =>
            [type] => 0
            [manufacturer] => 0
            [model] =>
            [Si] => Array
                (
                    [F] =>
                    [B] => S
                )

            [Sw] => Array
                (
                    [F] =>
                    [B] => 82
                )

            [parameters] => Array
                (
                    [0] => Array
                        (
                            [parameter_id] => 8
                            [value] => 175/70R13
                        )

                    [1] => Array
                        (
                            [parameter_id] =>
                            [value] =>
                        )

                    [2] => Array
                        (
                            [parameter_id] => 16
                            [value] =>
                        )

                    [3] => Array
                        (
                            [parameter_id] => 32
                            [value] =>
                        )

                    [4] => Array
                        (
                            [parameter_id] => 32
                            [value] =>
                        )

                    [5] => Array
                        (
                            [parameter_id] => 39
                            [value] =>
                        )

                    [6] => Array
                        (
                            [parameter_id] => 21
                            [value] => Array
                                (
                                    [price] => 620.00
                                    [currency] =>
                                )

                        )

                    [7] => Array
                        (
                            [parameter_id] => 25
                            [value] => 4
                        )

                )

            [required] => Array
                (
                    [0] => Array
                        (
                            [parameter_id] => 4
                            [value] => Bridgestone
                        )

                    [1] => Array
                        (
                            [parameter_id] => 1
                            [value] => Array
                                (
                                    [id] => 4198
                                    [model] => Blizzak Revo-GZ
                                    [manufacturer_id] => 15
                                    [manufacturer] => Bridgestone
                                    [alias] =>
                                )

                        )

                )

            [raw] => 175/70R13 | Bridgestone | | 175/70R13 Bridgestone Blizzak Revo-GZ 82S | 620 | 4
        )

    [4] => Array
        (
            [currency] => 2
            [existing] =>
            [R] => 13
            [W] => 175
            [H] => 70
            [I] =>
            [type] => 0
            [manufacturer] => 0
            [model] =>
            [Si] => Array
                (
                    [F] =>
                    [B] => T
                )

            [Sw] => Array
                (
                    [F] =>
                    [B] => 82
                )

            [parameters] => Array
                (
                    [0] => Array
                        (
                            [parameter_id] => 8
                            [value] => 175/70R13
                        )

                    [1] => Array
                        (
                            [parameter_id] =>
                            [value] =>
                        )

                    [2] => Array
                        (
                            [parameter_id] => 16
                            [value] =>
                        )

                    [3] => Array
                        (
                            [parameter_id] => 32
                            [value] =>
                        )

                    [4] => Array
                        (
                            [parameter_id] => 32
                            [value] =>
                        )

                    [5] => Array
                        (
                            [parameter_id] => 39
                            [value] =>
                        )

                    [6] => Array
                        (
                            [parameter_id] => 21
                            [value] => Array
                                (
                                    [price] => 329.00
                                    [currency] =>
                                )

                        )

                    [7] => Array
                        (
                            [parameter_id] => 25
                            [value] => 16
                        )

                )

            [required] => Array
                (
                    [0] => Array
                        (
                            [parameter_id] => 4
                            [value] => Debica
                        )

                    [1] => Array
                        (
                            [parameter_id] => 1
                            [value] => Navigator
                        )

                )

            [raw] => 175/70R13 | Debica | | 175/70R13 Debica Navigatar 2 82T | 329 | 16
        )

    [5] =>
)

*/