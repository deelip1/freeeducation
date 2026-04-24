<template>
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h3 class="h5">AI Poster Generator</h3>
      <p class="text-secondary">Upload image, choose template, generate Hindi + English poster.</p>
      <div class="row g-2">
        <div class="col-12 col-md-6">
          <input type="file" class="form-control" />
        </div>
        <div class="col-12 col-md-4">
          <select class="form-select">
            <option>Classic</option>
            <option>Academic</option>
            <option>Event</option>
          </select>
        </div>
        <div class="col-12 col-md-2 d-grid">
          <button type="button" class="btn btn-primary">Generate</button>
        </div>
      </div>
    </div>
  </div>
</template>
