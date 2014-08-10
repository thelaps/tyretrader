<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 12.12.13
 * Time: 0:28
 * To change this template use File | Settings | File Templates.
 */
class Price extends ActiveRecord\Model
{
    const WHEEL = 2;
    const TYRE = 1;

    public static $table_name = 'wheel_price';

    public static function getProductType($productType)
    {
        return (strtoupper($productType) == 'WHEEL') ? self::WHEEL : ((strtoupper($productType) == 'TYRE') ? self::TYRE : null);
    }

    private $scopeTables = null;

    public static function getSoldItems()
    {
        $model = new Price();
        $model->loadScopeData();
        $unionsSql = $model->makeUnions();
        if($unionsSql!=null){
            $sold = $model->find_by_sql($unionsSql);
            return $sold;
        }
    }

    public function getAllItems($post = null)
    {
        $model = new Price();
        $model->loadScopeData();
        $unionsSql = $model->makeUnions($post);
        $unionsSqlTotal = $model->makeUnions($post, true);
        $opt = new stdClass();
        $opt->total = $model->find_by_sql($unionsSqlTotal);
        $opt->total = $opt->total[0]->items;
        $opt->filter = (object)$post['filter'];
        $currentTime = time();
        if($unionsSql!=null){
            $opt_items = $model->find_by_sql($unionsSql);
            foreach ($opt_items as $item) {

                $timeDiff = abs($currentTime - $item->date);
                $numberDays = $timeDiff/86400;
                $numberDays = intval($numberDays);
                $item->assign_attribute('daysago', $numberDays);

                $item->assign_attribute('price_compiled', $item->makePriceWtihMargin());

                $item->assign_attribute('scopename', $item->makeName());
                $item->assign_attribute('time', date('d.m.Y', $item->date));

                $opt->items[$item->manufacturer_type][] = $item;
            }
            return $opt;
        }
    }

    public static function getOptItems($post = null)
    {
        $model = new Price();
        $model->loadScopeData();
        $unionsSql = $model->makeUnions($post);
        $unionsSqlTotal = $model->makeUnions($post, true);
        $opt = new stdClass();
        $opt->total = $model->find_by_sql($unionsSqlTotal);
        $opt->total = $opt->total[0]->items;
        $opt->filter = (object)$post['filter'];
        $currentTime = time();
        if($unionsSql!=null){
            $opt->items = $model->find_by_sql($unionsSql);
            foreach ($opt->items as $item) {

                $timeDiff = abs($currentTime - $item->date);
                $numberDays = $timeDiff/86400;
                $numberDays = intval($numberDays);
                $item->assign_attribute('daysago', $numberDays);

                $item->assign_attribute('price_compiled', $item->makePriceWtihMargin());

                $item->assign_attribute('scopename', $item->makeName());
                $item->assign_attribute('time', date('d.m.Y', $item->date));
            }
            return $opt;
        }
    }

    public static function getAnalitycsScope($post = null, $companyBilling = null)
    {
        $model = new Price();

        $regionId = null;
        if ( $companyBilling ) {

            $company = Company::getCompany($companyBilling->companyid);
            $regionId = City::getRegionId($company->cityid);

            $companyIds = Company::getAllByRegion($regionId);

            $companyIds = implode(', ', $companyIds);

            $rules = array(
                'model'=>array(
                    'field'=>'model_id',
                    'must'=>'='
                ),
                'manufacturer'=>array(
                    'field'=>'manufacturer_id',
                    'must'=>'='
                ),
                'size_r'=>array(
                    'field'=>'size_r',
                    'must'=>'=',
                    'multiple'=>'IN'
                ),
                'size_w'=>array(
                    'field'=>'size_w',
                    'must'=>'=',
                    'multiple'=>'IN'
                ),
                'size_h'=>array(
                    'field'=>'size_h',
                    'must'=>'=',
                    'multiple'=>'IN'
                ),
                'season'=>array(
                    'field'=>'season',
                    'must'=>'=',
                    'multiple'=>'IN'
                ),
                'type_transport'=>array(
                    'field'=>'type_transport',
                    'must'=>'=',
                    'multiple'=>'IN'
                ),
                'axle'=>array(
                    'field'=>'type_transport',
                    'must'=>'='
                ),
                'use'=>array(
                    'field'=>'type_transport',
                    'must'=>'='
                ),
                'company_id'=>array(
                    'field'=>'company_id',
                    'must'=>'='
                ),
                'city'=>array(
                    'field'=>'city_id',
                    'must'=>'=',
                    'multiple'=>'IN'
                ),
            );
            $productType = Price::getProductType($post['product-type']);

            switch ( $productType ) {
                case 1:
                    unset($post['wheel']);
                    break;
                case 2:
                    unset($post['tyre']);
                    break;
            }

            $filter = $model->makeFilterFromPost($post, $rules, 'r', true);
            $filterOuter = $model->makeFilterFromPost($post, $rules, 't', true);
            $filter .= ' AND r.manufacturer_type = '.$productType . ' AND r.stock_1 > 0 AND r.date > '.strtotime('-10 days') ;
            $filterOuter .= ' AND t.manufacturer_type = '.$productType . ' AND t.stock_1 > 0 AND t.date > '.strtotime('-10 days') ;

            $completeSql = 'SELECT
                                `s`.`avg_price_region`,
                                `s`.`min_price_region`,
                                `s`.`company_price`,
                                (SELECT MIN(`mc`.`price_1`)
                                    FROM `wheel_priceview` AS `mc`
                                    WHERE `mc`.`model_id`=`t`.`model_id`) AS `min_price_country`,
                                AVG(`t`.`price_1`) AS `avg_price_country`,
                                `t`.*
                            FROM `wheel_priceview` AS `t`
                            LEFT JOIN (
                                SELECT
                                AVG(`r`.`price_1`) AS `avg_price_region`,
                                (SELECT MIN(`mr`.`price_1`)
                                    FROM `wheel_priceview` AS `mr`
                                    WHERE `mr`.`model_id`=`r`.`model_id`
                                    AND `mr`.`company_id` IN ('.$companyIds.')) AS `min_price_region`,
                                `c`.`price_1` AS `company_price`,
                                `r`.`model_id`
                                FROM `wheel_priceview` AS `r`
                                LEFT JOIN `wheel_priceview` AS `c` ON `c`.`model_id`=`r`.`model_id` AND `c`.`company_id`='.$company->id.'
                                WHERE `r`.`company_id` IN ('.$companyIds.')
                                AND `c`.`price_1` IS NOT NULL
                                AND '.$filter.'
                                GROUP BY `r`.`model_id`
                            ) `s` ON `s`.`model_id`=`t`.`model_id`
                            WHERE `s`.`model_id` IS NOT NULL AND `t`.`company_id`='.$company->id.' AND '.$filterOuter.'
                            GROUP BY `t`.`model_id`, `t`.`size_h`, `t`.`size_w`, `t`.`size_r`';

            $analyticsScope = new stdClass();
            $analyticsScope->items = $model->find_by_sql($completeSql);
            $analyticsScope->total = count($analyticsScope->items);
            $analyticsScope->filter = new stdClass();//(object)$post['filter'];
            foreach ($analyticsScope->items as $item) {
                $item->avg_price_region = str_replace(',', '', number_format(round($item->avg_price_region, 2), 2));
                $item->min_price_region = str_replace(',', '', number_format(round($item->min_price_region, 2), 2));
                $item->company_price = str_replace(',', '', number_format(round($item->company_price, 2), 2));
                $item->min_price_country = str_replace(',', '', number_format(round($item->min_price_country, 2), 2));
                $item->avg_price_country = str_replace(',', '', number_format(round($item->avg_price_country, 2), 2));

                $pr = number_format(($item->company_price - $item->avg_price_region) / ($item->avg_price_region / 100), 1);
                $pc = number_format(($item->company_price - $item->avg_price_country) / ($item->avg_price_country / 100), 1);

                $item->assign_attribute('percentage_region', $pr);
                $item->assign_attribute('percentage_country', $pc);
                $item->assign_attribute('scopename', $item->makeName());
            }

            return $analyticsScope;
        }

        /*$model = new Price();
        $model->loadScopeData();
        $unionsSql = $model->makeUnions($post);
        $unionsSqlTotal = $model->makeUnions($post, true);
        $opt = new stdClass();
        $opt->total = $model->find_by_sql($unionsSqlTotal);
        $opt->total = $opt->total[0]->items;
        $opt->filter = (object)$post['filter'];
        $currentTime = time();
        if($unionsSql!=null){
            $opt->items = $model->find_by_sql($unionsSql);
            foreach ($opt->items as $item) {

                $timeDiff = abs($currentTime - $item->date);
                $numberDays = $timeDiff/86400;
                $numberDays = intval($numberDays);
                $item->assign_attribute('daysago', $numberDays);

                $item->assign_attribute('price_compiled', $item->makePriceWtihMargin());

                $item->assign_attribute('scopename', $item->makeName());
                $item->assign_attribute('time', date('d.m.Y', $item->date));
            }
            return $opt;
        }*/
    }

    public static function getModelFromPrice($modelId,$companyId,$priceId)
    {
        $model = new Price();
        $modelFromPrice = $model->find_by_sql('
            SELECT `wheel_priceview`.*, `wheel_user`.`firstName` as user, `wheel_user`.`phone`, `wheel_user`.`email`
            FROM `wheel_priceview` LEFT JOIN `wheel_user`
            ON `wheel_user`.`companyId`= `wheel_priceview`.`company_id`
            WHERE `wheel_priceview`.`model_id`='.$modelId.' AND `wheel_priceview`.`company_id`='.$companyId.' AND `wheel_priceview`.`id`='.$priceId);
        if (isset($modelFromPrice[0])) {
            $season = array('', 'Летняя', 'Зимняя', 'Всесезонная');
            $typeTransport = array('Диски', 'Легковые / 4x4', 'Легкогрузовые', 'Индустриальные', 'Грузовые', 'Мото');
            $modelFromPrice[0]->assign_attribute('type_transport_dict', $typeTransport[$modelFromPrice[0]->type_transport]);
            $modelFromPrice[0]->assign_attribute('season_dict', $season[$modelFromPrice[0]->season]);
            return $modelFromPrice[0];
        }
        return $model;
    }

    private function loadScopeData()
    {
        if ( !$this->find_by_sql('SHOW TABLES WHERE `Tables_in_wheels` LIKE \'wheel_priceview\'') ) {
            $priceExtractor = App::newJump('priceExtractor','modules');
            $priceExtractor->syncPrices();
        }

        $scope = array();

        $priceTables = $this->find_by_sql('SHOW TABLES WHERE `Tables_in_wheels` LIKE \'wheel_price_com%\'');

        foreach ($priceTables as $row) {
            $scope[] = $row->tables_in_wheels;
        }

        $this->scopeTables = $scope;
    }

    private function makeUnions($post = null, $isCountOnly = false)
    {
        $filter = $this->makeFilterFromPost($post);
        $ordering = $this->makeOrderingFromPost($post);
        $unionsSql = null;
        $completeSql = null;
        if($this->scopeTables!=null){
            /*$unionsSql = 'SELECT `wheel_price`.*, wheel_manufacturers.name AS manufacturer,
            wheel_models.name AS model,
            wheel_models.season, wheel_models.use,
            wheel_models.type_transport, wheel_models.axle,
            wheel_manufacturers2type.type as manufacturer_type,
            wheel_manufacturers2type.wheel_type as manufacturer_wheel_type
            FROM `wheel_price`
            LEFT JOIN wheel_manufacturers
            ON wheel_manufacturers.id=manufacturer_id
            LEFT JOIN wheel_manufacturers2type ON wheel_manufacturers.id=wheel_manufacturers2type.manufacturer_id
            LEFT JOIN wheel_models ON wheel_models.id=model_id';
            foreach ($this->scopeTables as $table){
                $unionsSql .= ' UNION SELECT `'.$table.'`.*, wheel_manufacturers.name AS manufacturer,
                    wheel_models.name AS model,
                    wheel_models.season, wheel_models.use,
                    wheel_models.type_transport, wheel_models.axle,
                    wheel_manufacturers2type.type as manufacturer_type,
                    wheel_manufacturers2type.wheel_type as manufacturer_wheel_type
                    FROM `'.$table.'`
                    LEFT JOIN wheel_manufacturers
                    ON wheel_manufacturers.id=manufacturer_id
                    LEFT JOIN wheel_manufacturers2type ON wheel_manufacturers.id=wheel_manufacturers2type.manufacturer_id
                    LEFT JOIN wheel_models ON wheel_models.id=model_id';
            }*/
            $unionsSql = 'wheel_priceview';
            $completeSql = 'SELECT '.(($isCountOnly)?'COUNT(*) AS items':'SQ.*,
            CONCAT_WS(\' \',SQ.`manufacturer`, SQ.`model`, SQ.`size_w`,
                SQ.`size_h`, SQ.`size_r`, SQ.`marking`, SQ.`technology`,
                SQ.`et`, SQ.`dia`, SQ.`pcd_1`, SQ.`pcd_2`) AS sqlscopename').' FROM `'.$unionsSql.'` SQ'.$filter.(($isCountOnly)?'':' '.$ordering.' LIMIT 0, 200');
        }
        return $completeSql;
    }

    private function makeOrderingFromPost($post)
    {
        $sqlOrdering = '';
        $default = array(
            'manufacturer' => 'BT',
            'date' => 'TB',
            'price_1' => 'BT'
        );
        if ( !empty($post['filter']) ) {
            $sqlOrdering = $this->implodeAssoc($post['filter']);
        } else {
            $sqlOrdering = $this->implodeAssoc($default);
        }
        return (!empty($sqlOrdering))?'ORDER BY '.$sqlOrdering:'';
    }

    private function implodeAssoc($array = array())
    {
        $string = '';
        $tmp = array();
        $rebuild = array(
            'TB'=>'DESC',
            'BT'=>'ASC'
        );
        foreach ($array as $key => $val) {
            if ( !empty($val) ) {
                $val = (isset($rebuild[$val]))?$rebuild[$val]:'ASC';
                $tmp[] = $key.' '.$val;
            }
        }
        $string = implode(', ', $tmp);
        return $string;
    }

    private function makeFilterFromPost($post, $customRules = null, $tableAlias = null, $isCleanRule = false)
    {
        $sqlFilter = '';
        if ($post!=null) {
            if (isset($post['tyre'])){
                if ( isset($post['tyre']['duo']) ) {
                    if ( $post['tyre']['duo'] != 1) {
                        unset($post['tyre']['size_w'][1]);
                        unset($post['tyre']['size_h'][1]);
                        unset($post['tyre']['size_r'][1]);
                    }
                }
                if ( !empty($post['tyre']['city']) ) {
                    $post['tyre']['city'] = Company::getAllByRegion($post['tyre']['city']);
                }
                $sqlFilter .= $this->makeRule($post['tyre'], $customRules, $tableAlias, $isCleanRule);
            } elseif (isset($post['wheel'])){
                if ( !empty($post['wheel']['city']) ) {
                    $post['wheel']['city'] = Company::getAllByRegion($post['wheel']['city']);
                }
                $sqlFilter .= $this->makeRule($post['wheel'], $customRules, $tableAlias, $isCleanRule);
            }
        }
        return $sqlFilter;
    }

    private function makeRule($data, $customRules = array(), $tableAlias = null, $isCleanRule = false)
    {
        $rules = array(
            'model'=>array(
                'field'=>'model_id',
                'must'=>'='
            ),
            'manufacturer'=>array(
                'field'=>'manufacturer_id',
                'must'=>'='
            ),
            'size_r'=>array(
                'field'=>'size_r',
                'must'=>'=',
                'multiple'=>'IN'
            ),
            'size_w'=>array(
                'field'=>'size_w',
                'must'=>'=',
                'multiple'=>'IN'
            ),
            'size_h'=>array(
                'field'=>'size_h',
                'must'=>'=',
                'multiple'=>'IN'
            ),
            'season'=>array(
                'field'=>'season',
                'must'=>'=',
                'multiple'=>'IN'
            ),
            'type_transport'=>array(
                'field'=>'type_transport',
                'must'=>'=',
                'multiple'=>'IN'
            ),
            'axle'=>array(
                'field'=>'type_transport',
                'must'=>'='
            ),
            'use'=>array(
                'field'=>'type_transport',
                'must'=>'='
            ),
            'company_id'=>array(
                'field'=>'company_id',
                'must'=>'='
            ),
            'notcompany_id'=>array(
                'field'=>'company_id',
                'must'=>'!='
            ),
            'city'=>array(
                'field'=>'company_id',
                'must'=>'=',
                'multiple'=>'IN'
            ),
        );
        if ( $customRules != null ) {
            $rules = $customRules;
        }
        $makedRules = array();
        foreach ($data as $key => $val){
            if(array_key_exists($key, $rules) && !empty($val)){
                if(is_array($val)){
                    $makedRulesJoin = array();
                    foreach($val as $nextval){
                        if(!empty($nextval)){
                            $makedRulesJoin[]=$nextval;
                        }
                    }
                    if (!empty($makedRulesJoin)) {
                        $makedRules[] = (($tableAlias != null) ? $tableAlias.'.' : '') . $rules[$key]['field'].' '.$rules[$key]['multiple'].' ('.implode(', ', $makedRulesJoin).')';
                    }
                }else{
                    $makedRules[] = (($tableAlias != null) ? $tableAlias.'.' : '') . $rules[$key]['field'].' '.$rules[$key]['must'].' '.$val;
                }
            }
        }
        if ( !$isCleanRule ) {
            $makedRules[] = (($tableAlias != null) ? $tableAlias.'.' : '') . 'stock_1 > 0';
            $makedRules[] = (($tableAlias != null) ? $tableAlias.'.' : '') . 'date > '.strtotime('-10 days');
        }
        if(sizeof($makedRules)>0){
            $strRule = implode(' AND ', $makedRules);
            return ($isCleanRule) ? $strRule : ' WHERE '.$strRule;
        }
        return '';
    }

    public function makePriceWtihMargin()
    {
        $totalPrice = $this->price_1;
        Margin::useMargin($this, $totalPrice);
        return $totalPrice;
    }

    public function makeName()
    {
        $technology = null;
        $marking = null;
        $spike = null;
        $helper = Helper::extras();
        $technology = Helper::getObjBy($this->technology, $helper['technology'], 'id');
        $marking = Helper::getObjBy($this->marking, $helper['marking'], 'id');
        $spike = Helper::getObjBy($this->spike, $helper['spike'], 'id');
        $sw_index = array();
        $size_i_c = '';
        $size_i_z = '';
        if ( $this->size_i != null ) {
            switch ($this->size_i) {
                case 'C':
                   $size_i_c = 'C';
                    break;
                case 'Z':
                   $size_i_z = 'Z';
                    break;
            }
        }

        if (!empty($this->sw_f)) {
            array_push($sw_index, $this->sw_f.''.$this->si_f);
        }
        if (!empty($this->sw_b)) {
            array_push($sw_index, $this->sw_b.''.$this->si_b);
        }

        $sw_index = implode('/', $sw_index);

        $scopename = array(
            $this->manufacturer,
            $this->model,
            $this->size_w.(($this->size_h!=null)?'/'.$this->size_h:'').' '.$size_i_z.'R'.$this->size_r.
                $size_i_c.' '.
                $sw_index.' '.
                ((isset($technology->name))?$technology->name:'').' '.
                ((isset($spike->name))?$spike->name:'').' '.
                ((isset($marking->name))?$marking->name:'').' '
        );

        $scopename = implode(' ',$scopename);

        return $scopename;
    }

    public function getItemCompany()
    {
        return Company::getCompanyById($this->company_id);
    }
}