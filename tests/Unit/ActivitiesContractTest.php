<?php

namespace Tests\Unit;

use App\Models\Activity;

trait ActivitiesContractTest
{
    /** @test */
    public function has_many_activities()
    {
        $model = $this->getActivityModel();

        create(Activity::class, [
            'user_id' => $model->user_id,
            'subject_id' => $model->id,
            'subject_type' => $model->getMorphClass(),
            'type' => $this->getActivityType()
        ]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphMany', $model->activities());
    }

    abstract protected function getActivityModel();
    abstract protected function getActivityType();
}
