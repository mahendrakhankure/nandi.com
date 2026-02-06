import mongoose, { Schema, Document } from 'mongoose';

export interface ICurrencyRate extends Document {
  currencyCode: string;
  currencyName: string;
  rate: number;
  status: 'active' | 'inactive';
  updatedBy: mongoose.Types.ObjectId;
  createdAt: Date;
  updatedAt: Date;
}

const CurrencyRateSchema: Schema = new Schema({
  currencyCode: {
    type: String,
    required: true,
    unique: true,
    trim: true,
    uppercase: true
  },
  currencyName: {
    type: String,
    required: true,
    trim: true
  },
  rate: {
    type: Number,
    required: true,
    min: 0
  },
  status: {
    type: String,
    enum: ['active', 'inactive'],
    default: 'active'
  },
  updatedBy: {
    type: Schema.Types.ObjectId,
    ref: 'Admin',
    required: true
  }
}, {
  timestamps: true
});

// Indexes for better performance
CurrencyRateSchema.index({ currencyCode: 1 });
CurrencyRateSchema.index({ status: 1 });

export const CurrencyRate = mongoose.model<ICurrencyRate>('CurrencyRate', CurrencyRateSchema);

