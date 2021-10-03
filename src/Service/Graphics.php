<?php


namespace App\Service;


use App\Entity\BudgetLine;
use App\Entity\Project;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Graphics
{
  public function projectBudgets(Project $project):Collection
  {
  $budgetLines=$project->getBudgetlines();
  $free=new ArrayCollection();
  $percentage=100;
  foreach($budgetLines as $budgetLine) {
      $percentage-=$budgetLine->getPerCentage();
      $free->add(['name'=>$budgetLine->getName(),'percentage'=>$budgetLine->getPercentage()]);
  }
  $free->add(['name'=>'free','percentage'=>$percentage]);
  return $free;

  }
  public function budgetLineUsedMoney(BudgetLine $budgetLine): float
  {
      $operations=$budgetLine->getOperations();
      $sum=0;
      foreach ($operations as $operation){
          $sum+=$operation->getPrice();
      }
      return $sum;
  }
  public function budgetLineMoney(BudgetLine $budgetLine): float
  {
      $per=$budgetLine->getPercentage();
      $budget=$budgetLine->getProject()->getBudget();
      return $per*$budget/100;
  }
  public function budgetLineAvailableMoney(BudgetLine $budgetLine):float
  {
          return  $this->budgetLineMoney($budgetLine)-$this->budgetLineUsedMoney($budgetLine);
  }
}