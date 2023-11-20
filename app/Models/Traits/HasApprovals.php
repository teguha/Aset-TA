<?php

namespace App\Models\Traits;

use App\Models\Auth\User;
use App\Models\Globals\Approval;
use App\Models\Globals\MenuFlow;

trait HasApprovals
{
    /** Approval by all module **/
    public function approvals()
    {
        return $this->morphMany(Approval::class, 'target');
    }

    /** Approval by specific module **/
    public function approval($module)
    {
        return $this->approvals()->whereModule($module);
    }

    /** Use this function when submit **/
    public function generateApproval($module, $upgrade = false)
    {
        if ($this->approval($module . ($upgrade ? '_upgrade' : ''))->exists()) {
            // return $this->resetStatusApproval($module . $upgrade ? '_upgrade' : '');
            $this->approval($module . ($upgrade ? '_upgrade' : ''))->delete();
        }

        $flows = MenuFlow::hasModule($module)->orderBy('order')->get();
        if (!$flows->count()) {
            return $this->responseError(
                [
                    'message' => 'Flow Approval belum diatur!'
                ]
            );
        }

        $results = [];
        foreach ($flows as $item) {
            $results[] = new Approval(
                [
                    'module'    => $module . ($upgrade ? '_upgrade' : ''),
                    'role_id'   => $item->role_id,
                    'order'     => $item->order,
                    'type'      => $item->type,
                    'status'    => 'new',
                ]
            );
        }

        $this->approval($module)->saveMany($results);
        return null;
    }

    public function generateApprovalWorksheet($module, $record)
    {
        if ($this->approval($module)->exists()) {
            return $this->resetStatusApproval($module);
        }

        $results = [];
        // ketua tim
        $results[0] = new Approval([
            'module' => $module,
            'role_id' => $record->summary->leader->roles[0]->id,
            'order' => 1,
            'type' => 1,
            'status' => 'new',
        ]);

        // penanggung jawab
        $results[1] = new Approval([
            'module' => $module,
            'role_id' => $record->summary->pic->roles[0]->id,
            'order' => 1,
            'type' => 1,
            'status' => 'new',
        ]);

        return $this->approval($module)->saveMany($results);
    }

    public function resetStatusApproval($module)
    {
        return $this->approval($module)
            ->update(
                [
                    'status'      => 'new',
                    'user_id'     => null,
                    'position_id' => null,
                    'note'        => null,
                    'approved_at' => null,
                ]
            );
    }

    /** Use this function before submit **/
    public function getFlowApproval($module)
    {
        return MenuFlow::whereHas(
            'menu',
            function ($q) use ($module) {
                $q->where('module', $module);
            }
        )
            ->orderBy('order')
            ->get()
            ->groupBy('order');
    }

    public function rejected($module)
    {
        return $this->approval($module)->whereStatus('rejected')->latest()->first();
    }

    public function approved($module)
    {
        return $this->approval($module)->whereStatus('approved')->get();
    }

    public function firstNewApproval($module)
    {
        return $this->approval($module)->whereStatus('new')->orderBy('order')->first();
    }

    /** Check auth user can action approval by specific module **/
    public function checkApproval($module)
    {
        if ($new = $this->firstNewApproval($module)) {
            $user = auth()->user();
            return $this->approval($module)
                ->where('order', $new->order)
                ->whereStatus('new')
                ->whereIn('role_id', $user->getRoleIds())
                ->exists();
        }

        return false;
    }

    public function getNewUserIdsApproval($module)
    {
        $role_ids = [];
        if ($new = $this->firstNewApproval($module)) {
            $role_ids = $this->approval($module)
                ->where('order', $new->order)
                ->whereStatus('new')
                ->pluck('role_id')
                ->toArray();
        }
        // ini untuk yg kedua (DIY)
        // $temps = $this->approval($module)
        //     ->whereStatus('new')
        //     ->orderBy('order')
        //     ->get();
        // if($temps->count()==1){
        //     if ($new = $this->firstNewApproval($module)) {
        //         $role_ids = $this->approval($module)
        //             ->where('order', $new->order)
        //             ->whereStatus('new')
        //             ->pluck('role_id')
        //             ->toArray();
        //     }
        // }else{
        //     foreach($temps as $temp){
        //         $temp_role = $this->approval($module)
        //             ->where('order', $temp->order)
        //             ->whereStatus('new')
        //             ->pluck('role_id')
        //             ->first();
        //         array_push($role_ids, $temp_role);

        //     }
        // }
        return User::whereHas('roles', function ($q) use ($role_ids) {
            $q->whereIn('id', $role_ids);
        })
            ->pluck('id')
            ->toArray();
    }

    /** Reject data by specific module by specific module **/
    public function rejectApproval($module, $note)
    {
        if ($new = $this->firstNewApproval($module)) {
            $user = auth()->user();
            return $this->approval($module)
                ->where('order', $new->order)
                ->whereStatus('new')
                ->whereIn('role_id', $user->getRoleIds())
                ->update([
                    'status' => 'rejected',
                    'user_id' => $user->id,
                    'position_id' => $user->position_id,
                    'note' => $note,
                    'approved_at' => null,
                ]);
        }
    }

    /** Approve data by specific module **/
    public function approveApproval($module, $note = null)
    {
        if ($new = $this->firstNewApproval($module)) {
            $user = auth()->user();
            return $this->approval($module)
                ->where('order', $new->order)
                ->whereStatus('new')
                ->whereIn('role_id', $user->getRoleIds())
                ->update([
                    'status' => 'approved',
                    'user_id' => $user->id,
                    'position_id' => $user->position_id,
                    'note' => $note,
                    'approved_at' => now(),
                ]);
        }
    }
}
