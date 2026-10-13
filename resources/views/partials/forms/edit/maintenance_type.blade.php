          <!-- Maintenance Type -->
          <div class="form-group {{ $errors->has('maintenance_type_id') ? ' has-error' : '' }}">
              <label for="maintenance_type_id" class="col-md-3 control-label">
                  {{ trans('admin/maintenances/form.asset_maintenance_type') }}
              </label>
              <div class="col-md-7">
                  @if (isset($maintenanceTypes) && $maintenanceTypes->count())
                      <select name="maintenance_type_id" id="maintenance_type_id"
                              class="form-control select2"
                              data-placeholder="{{ trans('admin/maintenances/form.select_type') }}"
                              style="width: 100%;"
                              aria-label="maintenance_type_id" required>
                          <option value=""></option>
                          @foreach ($maintenanceTypes as $type)
                              <option value="{{ $type->id }}"
                                  {{ old('maintenance_type_id', $item->maintenance_type_id) == $type->id ? 'selected' : '' }}>
                                  {{ $type->name }}
                              </option>
                          @endforeach
                      </select>
                  @else
                      {{-- Fallback to legacy string-based dropdown if no types configured yet --}}
                      <x-input.select
                          name="asset_maintenance_type"
                          :options="$maintenanceType ?? []"
                          :selected="old('asset_maintenance_type', $item->asset_maintenance_type)"
                          data-placeholder="{{ trans('admin/maintenances/form.select_type')}}"
                          includeEmpty="true"
                          style="width:100%;"
                          aria-label="asset_maintenance_type"
                      />
                  @endif
                  <x-form.error name="maintenance_type_id" />
              </div>

              <div class="col-md-1 col-sm-1 text-left">
                  @can('create', \App\Models\MaintenanceType::class)
                      <x-button.modal-add type="maintenance-type" target="maintenance_type_id"/>
                  @endcan
              </div>
          </div>
