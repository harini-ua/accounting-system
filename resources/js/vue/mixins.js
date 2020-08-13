import axios from "axios";

export const showError = {
    methods: {
        showError: function(error) {

            console.error(error);

            let text = 'Please try again later!';

            if (error.response.data) {
                if (error.response.data.message) {
                    text = error.response.data.message;
                } else if (error.message) {
                    text = error.message;
                }

                if (error.response.data.errors) {
                    let errors = '';
                    for (let prop in error.response.data.errors) {
                        errors += '<br>' + error.response.data.errors[prop][0];
                    }
                    text += errors;
                }
            }

            swal('Error!', text, 'error');
        },
    },
}

export const destroy = {
    methods: {
        destroy: function(deleteLink, callback) {
            swal({
                title: 'Are you sure?',
                text: 'Resource will be deleted!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    axios.delete(deleteLink)
                        .then(resp => {
                            swal({
                                title : resp.success === false ? 'Error!' : 'Successfully!',
                                text  : resp.message,
                                type  : resp.success === false ? 'error' : 'success',
                            });
                            callback();
                        })
                        .catch((error) => this.showError(error));
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    return false;
                }
            });
        }
    },
}
