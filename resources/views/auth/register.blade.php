<div class="row mb-3">
    <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Role Pengguna') }}</label>

    <div class="col-md-6">
        <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
            <option value="" disabled selected>Pilih Role</option>
            <option value="admin">Admin</option>
            <option value="operator">Operator</option>
        </select>

        @error('role')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>