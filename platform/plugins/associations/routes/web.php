<?php

use Botble\Associations\Http\Controllers\AssociationsController;


Route::group(['prefix' => 'admin/marketplaces/settings', 'middleware' => ['web', 'auth']], function () {
    Route::get('/associations', [AssociationsController::class, 'index'])->name('associations.index');
    Route::get('/associations/create', [AssociationsController::class, 'create'])->name('associations.create');
    Route::post('/associations/store', [AssociationsController::class, 'store'])->name('associations.store');
    Route::get('/associations/edit/{id}', [AssociationsController::class, 'edit'])->name('associations.edit');
    Route::put('/associations/update/{id}', [AssociationsController::class, 'update'])->name('associations.update');
    Route::delete('/associations/delete/{id}', [AssociationsController::class, 'destroy'])->name('associations.delete');
    Route::post('/associations/import', [AssociationsController::class, 'importJson'])->name('associations.import');
    
    // Approval Routes
    Route::patch('/associations/approve/{id}', [AssociationsController::class, 'approve'])->name('associations.approve');
    Route::patch('/associations/reject/{id}', [AssociationsController::class, 'reject'])->name('associations.reject');

    // Status Routes
    Route::post('/associations/toggle-status/{id}', [AssociationsController::class, 'toggleStatus'])->name('associations.toggleStatus');
    Route::post('/associations/update-status', [AssociationsController::class, 'updateStatus'])->name('associations.update.status');
});