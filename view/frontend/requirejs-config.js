var config = {
    paths: {
        'owlcarousel': "Ecentura_Portfolio/js/owl.carousel"
    },
    shim: {
        'owlcarousel': {
            deps: ['jquery']
        }
    },

    map: {
        '*': {
            'Magento_Checkout/template/payment/before-place-order.html':
                'Ecentura_Portfolio/template/payment/before-place-order.html'
        }
    }
};

