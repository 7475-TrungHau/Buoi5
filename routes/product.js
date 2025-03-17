var express = require('express');
var router = express.Router();

var Product = require('../schemas/Product');

router.get('/', async function (req, res, next) {
    try {
        const product = await Product.find();
        res.send(product);
    } catch (err) {
        res.json({ message: err });
    }
});

router.post('/', async function (req, res, next) {
    const product = new Product(req.body);
    try {
        const saveProduct = await product.save();
        res.json(saveProduct);

    } catch (err) {

        res.json({ message: err });
    }
});

router.patch('/:name', async function (req, res, next) {
    try {
        const updateProduct = await Product.updateOne({ name: req.params.name }, { $set: req.body });

        res.json(updateProduct);
    } catch (err) {
        res.json({ message: err });
    }
})

module.exports = router;
