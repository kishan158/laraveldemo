@extends('back.vendor.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Inspection Appliance</h4>


    </div>

    <div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-6">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Add Inspection</div>
                    <div class="ibox-tools">
                        <!-- Plus button to add more forms -->
                        <a class="ibox-collapse" onclick="addForm()">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>

                <!-- Single form that handles all the input fields -->
                <form action="{{ route('vendorOrder.order.inspection.submit', $order->id) }}" method="post">
                    @csrf
                    <div class="ibox-body" id="form-container">
                        <!-- Initial form (cannot be removed) -->
                        <div class="extra-form">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>Work</label>
                                    <input class="form-control" type="text" name="extra_work[]" placeholder="Enter Extra Work" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Price</label>
                                    <input class="form-control" type="text" name="price_added[]" placeholder="Enter Price" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit button at the bottom -->
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let formCount = 1;

// Function to add a new form section (not a separate form)
function addForm() {
    const formContainer = document.getElementById('form-container');

    // Create a new form block (not a separate form)
    const newForm = document.createElement('div');
    newForm.classList.add('extra-form');
    newForm.setAttribute('data-id', formCount++);

    newForm.innerHTML = `
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>Work</label>
                <input class="form-control" type="text" name="extra_work[]" placeholder="Enter Extra Work" required>
            </div>
            <div class="col-sm-6 form-group">
                <label>Price</label>
                <input class="form-control" type="text" name="price_added[]" placeholder="Enter Price" required>
            </div>
            <div class="col-sm-12 text-right mt-2">
                <!-- Minus button for removing this specific section -->
                <button type="button" class="btn btn-danger" onclick="removeForm(this)">-</button>
            </div>
        </div>
    `;

    // Append the new section to the container
    formContainer.appendChild(newForm);
}

// Function to remove a specific form section
function removeForm(button) {
    const formContainer = document.getElementById('form-container');
    const formToRemove = button.closest('.extra-form');
    
    // Remove the form section only if there's more than one present
    if (formContainer.children.length > 1) {
        formContainer.removeChild(formToRemove);
    }
}
</script>


@endsection