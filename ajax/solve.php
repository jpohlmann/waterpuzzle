<?php
require_once '../Classes/BucketFactory.php';
require_once '../Classes/SavedValues.php';
require_once '../Classes/Bucket.php';
$bucketFactory        = new BucketFactory();
$responseObj          = new stdClass();
$responseObj->success = false;
$savedSolutions       = SavedValues::readFromFile();
$bestSolution         = null;
$existingSolutionKey  = '';
for ($x=1; $x <= $_POST['bucketNum']; $x++) {
    $existingSolutionKey .= $_POST['bucket'.$x].",";
}
$existingSolutionKey .= $_POST['target'];
if (array_key_exists(
        $existingSolutionKey,
        $savedSolutions->solutions
)
) {
    $responseObj->success  = true;
    $responseObj->solution = $savedSolutions->solutions->$existingSolutionKey;
} else {
    $combinations = BucketFactory::getCombinations($_POST['bucketNum']);
    foreach ($combinations as $combination) {
        $bucket1 = $combination[0];
        $bucket2 = $combination[1];
        try {
            $solutionArray = $bucketFactory->solveProblem(
                new Bucket($_POST['bucket'.$bucket1], $bucket1),
                new Bucket($_POST['bucket'.$bucket2], $bucket2),
                $_POST['target']
            );
            $responseObj->success = true;
            if ((is_null($bestSolution))
                || (sizeof($solutionArray) < sizeof($bestSolution))
            ) {
                $bestSolution = $solutionArray;
            }
        } catch(Exception $e) {
            $responseObj->error = $e->getMessage();
        }
    }
    if (!is_null($bestSolution)) {
        $savedSolutions->solutions->$existingSolutionKey = $solutionArray;
        SavedValues::writeToFile($savedSolutions);
        $responseObj->solution = $bestSolution;
        unset($responseObj->error);
    }
}
echo json_encode($responseObj);
