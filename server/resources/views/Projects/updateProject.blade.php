    <div class="modal fade" id="updateProjectModal{{ $project->id }}" tabindex="-1" aria-labelledby="updateProjectModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST"
                  action="{{ route('admin.projects.update', ['project' => $project]) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Update your project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center mb-3 border-">
                        <img src="{{ url('storage/' . ($project->preview_image == null ? 'images/default-img-for-project.jpg' : $project->preview_image)) }}" class="card-img-top rounded-2"
                             style="width: 286px; height: 10rem" alt="none image">
                    </div>
                    <input
                        class="form-control mb-3"
                        type="text"
                        placeholder="Name of project"
                        name="name"
                        value="{{ old('name', $project->name) }}"
                        class="@error('name') is-invalid @enderror"
                    >
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input
                        class="form-control mb-3"
                        type="text"
                        placeholder="Descriptions"
                        name="descriptions"
                        value="{{ old('descriptions', $project->descriptions) }}"
                        class="@error('descriptions') is-invalid @enderror"
                    >
                    @error('descriptions')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input
                        class="form-control"
                        type="file"
                        name="preview_image"
                        value="{{ old('preview_image') }}"
                        class="@error('preview_image') is-invalid @enderror"
                    >
                    @error('preview_image')
                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-primary">Update</button>

                </div>
            </form>
        </div>
    </div>


