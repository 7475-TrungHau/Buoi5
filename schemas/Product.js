var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var ProductSchema = new Schema({
    name: {
        type: String,
        required: true,
        unique: true,
    },
    price: {
        type: Number,
        required: true,
        default: 0
    },
    description: {
        type: String,
        default: ''
    },
    quanlity: {
        type: Number,
        default: 0
    },
    image: {
        type: String,
        default: ''
    }
}, {
    timestamps: true

});

module.exports = mongoose.model('product', ProductSchema);