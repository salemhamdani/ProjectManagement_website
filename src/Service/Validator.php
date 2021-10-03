<?php


namespace App\Service;


use App\Entity\BudgetLine;
use App\Entity\Operation;
use App\Entity\PaymentTranche;
use App\Entity\Project;

class Validator
{
    private $graphics;

    public function __construct(Graphics $graphics)
    {
        $this->graphics = $graphics;
    }

    public function validateOperation(Operation $operation):bool
    {
      $available=$this->graphics->budgetLineAvailableMoney($operation->getBudgetLine());
      if ($operation->getId())
      {
          $available+=$operation->getPrice();
      }
      return $operation->getPrice()<=$available;
    }
    public function availableBudgetLinePercentage(Project $project):float
    {
        $sum=0;
        $budgetLines=$project->getBudgetlines();
        foreach ($budgetLines as $budgetLine)
        {
            $sum+=$budgetLine->getPercentage();
        }
        return 100-$sum;
    }
    public function validateBudgetLine(BudgetLine $budgetLine):bool
    {
     $project=$budgetLine->getProject();
     $per=$this->availableBudgetLinePercentage($project);
     if($budgetLine->getId())
     {
         $per+=$budgetLine->getPercentage();
     }
     return $budgetLine->getPercentage()<=$per;

    }
    public function unpaidOperationSum(Operation $operation):float
    {
        $paymentTranches=$operation->getPaymentTranche();
        $sum=0;
        foreach($paymentTranches as $paymentTranche)
        {
            $sum+=$paymentTranche->getValue();
        }
        return $operation->getPrice()-$sum;

    }
    public function validatePaymentTranche(PaymentTranche $paymentTranche):bool
    {
        $condition=$this->unpaidOperationSum($paymentTranche->getOperation());
        if ($paymentTranche->getId()!==null){
            $condition+=$paymentTranche->getValue();
        }
      return $paymentTranche->getValue()<=$condition;
    }

}