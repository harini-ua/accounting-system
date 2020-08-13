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
