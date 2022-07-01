<div class="modal fade" id="sendEmailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Send Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" action="{{ Route('employee.email.create', $employee->id) }}" method="POST"
          id="sendEmailForm">
          @csrf
          <div class="col-md-12">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
              id="subject" value="{{ old('subject') ?? '' }}" />
          </div>
          <div class="col-md-12">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="message" rows="4">{{ old('message') ?? '' }}</textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary me-auto" form="sendEmailForm" value="submit">Send</button>
        <a class="text-danger" role="button" data-bs-dismiss="modal">Cancel</a>
      </div>
    </div>
  </div>
</div>
