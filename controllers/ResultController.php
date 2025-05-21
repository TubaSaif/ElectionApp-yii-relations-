<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\PollingUnit;
use app\models\Lga;
use app\models\AnnouncedPuResults;
use app\models\Party;

class ResultController extends Controller
{
    // Question 1
    // public function actionPollingUnitResult()
    // {
    //     $units = PollingUnit::find()->all();
    //     $results = [];
    //     $selectedUnitId = Yii::$app->request->post('polling_unit_uniqueid');

    //     if ($selectedUnitId) {
    //         $results = AnnouncedPuResults::find()
    //             ->where(['polling_unit_uniqueid' => $selectedUnitId])
    //             ->all();
    //     }

    //     return $this->render('polling-unit-result', [
    //         'units' => $units,
    //         'results' => $results,
    //         'selectedUnitId' => $selectedUnitId,
    //     ]);
    // }
    public function actionPollingUnitResult()
    {
        $units = PollingUnit::find()->all();

        $selectedUnitId = Yii::$app->request->post('polling_unit_uniqueid');

        $results = null;
        if ($selectedUnitId) {
            $pollingUnit = PollingUnit::findOne($selectedUnitId);
            if ($pollingUnit) {
                // Use the relation to get the results
                $results = $pollingUnit->announcedPuResults;
            }
        }

        return $this->render('polling-unit-result', [
            'units' => $units,
            'selectedUnitId' => $selectedUnitId,
            'results' => $results,
        ]);
    }

    // Question 2: using sql queries
    // public function actionLgaResult()
    // {
    //     $lgas = Lga::find()->where(['state_id' => 25])->all(); // Delta State only
    //     $results = [];
    //     $totals = [];
    //     $parties = [];
    //     $selectedLgaId = Yii::$app->request->post('lga_id');

    //     if ($selectedLgaId) {
    //         $pollingUnits = PollingUnit::find()
    //             ->where(['lga_id' => $selectedLgaId])
    //             ->all();

    //         $allParties = (new \yii\db\Query())
    //             ->select(['partyid', 'partyname'])
    //             ->from('party')
    //             ->all();

    //         foreach ($allParties as $party) {
    //             $parties[] = $party['partyname'];
    //         }

    //         foreach ($pollingUnits as $pu) {
    //             $rawResults = (new \yii\db\Query())
    //                 ->select(['party_abbreviation', 'party_score'])
    //                 ->from('announced_pu_results')
    //                 ->where(['polling_unit_uniqueid' => $pu->uniqueid])
    //                 ->indexBy('party_abbreviation')
    //                 ->all();

    //             $unitResults = [];
    //             foreach ($allParties as $party) {
    //                 $partyId = $party['partyid'];
    //                 $partyName = $party['partyname'];
    //                 $score = isset($rawResults[$partyId]) ? (int)$rawResults[$partyId]['party_score'] : 0;

    //                 $unitResults[] = [
    //                     'partyname' => $partyName,
    //                     'partyid' => $partyId,
    //                     'party_score' => $score,
    //                 ];

    //                 if (!isset($totals[$partyName])) {
    //                     $totals[$partyName] = 0;
    //                 }
    //                 $totals[$partyName] += $score;
    //             }

    //             $results[] = [
    //                 'polling_unit_name' => $pu->polling_unit_name,
    //                 'unit_id' => $pu->uniqueid,
    //                 'results' => $unitResults,
    //             ];
    //         }
    //     }

    //     return $this->render('lga-result', [
    //         'lgas' => $lgas,
    //         'results' => $results,
    //         'totals' => $totals,
    //         'selectedLgaId' => $selectedLgaId,
    //         'parties' => $parties,
    //     ]);
    // }
    //..................................................................
    // public function actionLgaResult()
    // {
    //     $lgas = Lga::find()->all();
    //     $selectedLgaId = Yii::$app->request->post('lga_id');

    //     $results = [];
    //     $parties = [];

    //     if ($selectedLgaId) {
    //         $lga = Lga::find()
    //             ->with(['pollingUnits.announcedPuResults']) // eager load for efficiency
    //             ->where(['lga_id' => $selectedLgaId])
    //             ->one();

    //         if ($lga) {
    //             foreach ($lga->pollingUnits as $unit) {
    //                 $unitResults = [];

    //                 foreach ($unit->announcedPuResults as $result) {
    //                     $unitResults[] = [
    //                         'partyname' => $result->party_abbreviation,
    //                         'party_score' => $result->party_score,
    //                     ];

    //                     if (!in_array($result->party_abbreviation, $parties)) {
    //                         $parties[] = $result->party_abbreviation;
    //                     }
    //                 }

    //                 $results[] = [
    //                     'unit_id' => $unit->polling_unit_id,
    //                     'polling_unit_name' => $unit->polling_unit_name,
    //                     'results' => $unitResults,
    //                 ];
    //             }
    //         }
    //     }

    //     return $this->render('lga-result', [
    //         'lgas' => $lgas,
    //         'selectedLgaId' => $selectedLgaId,
    //         'results' => $results,
    //         'parties' => $parties,
    //     ]);
    // }
    public function actionLgaResult()
    {
        $lgas = Lga::find()->all();
        $selectedLgaId = Yii::$app->request->post('lga_id');
        $results = [];
    
        // Get all parties from the Party table
        $partyNames = Party::find()
            ->select('partyname') 
            ->orderBy('partyname')
            ->column();
    
        if ($selectedLgaId) {
            $lga = Lga::find()
                ->with(['pollingUnits.announcedPuResults'])
                ->where(['lga_id' => $selectedLgaId])
                ->one();
    
            if ($lga) {
                foreach ($lga->pollingUnits as $unit) {
                    $unitResults = [];
    
                    foreach ($unit->announcedPuResults as $res) {
                        $unitResults[$res->party_abbreviation] = (int)$res->party_score;
                    }
    
                    $results[] = [
                        'unit_id' => $unit->polling_unit_id,
                        'polling_unit_name' => $unit->polling_unit_name,
                        'results' => $unitResults,
                    ];
                }
            }
        }
    
        return $this->render('lga-result', [
            'lgas' => $lgas,
            'selectedLgaId' => $selectedLgaId,
            'results' => $results,
            'parties' => $partyNames,
        ]);
    }
    


   

}

?>