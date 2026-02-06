import mongoose, { Schema, Document } from 'mongoose';

export interface IUserGame extends Document {
  customerId: mongoose.Types.ObjectId;
  bazarName: mongoose.Types.ObjectId;
  gameType: 'regular' | 'starline' | 'kingbazar' | 'worli' | 'instantworli';
  betNumber: string;
  betAmount: number;
  pointInRs: number;
  winningInRs: number;
  commissionInRs: number;
  resultDate: Date;
  status: 'P' | 'V' | 'C' | 'W' | 'L'; // Pending, Verified, Cancelled, Win, Loss
  resultNumber?: string;
  resultTime?: string;
  declaredAt?: Date;
  createdAt: Date;
  updatedAt: Date;
}

const UserGameSchema: Schema = new Schema({
  customerId: {
    type: Schema.Types.ObjectId,
    ref: 'User',
    required: true
  },
  bazarName: {
    type: Schema.Types.ObjectId,
    ref: 'GameType',
    required: true
  },
  gameType: {
    type: String,
    enum: ['regular', 'starline', 'kingbazar', 'worli', 'instantworli'],
    required: true
  },
  betNumber: {
    type: String,
    required: true,
    trim: true
  },
  betAmount: {
    type: Number,
    required: true,
    min: 1
  },
  pointInRs: {
    type: Number,
    required: true,
    min: 0
  },
  winningInRs: {
    type: Number,
    default: 0,
    min: 0
  },
  commissionInRs: {
    type: Number,
    default: 0,
    min: 0
  },
  resultDate: {
    type: Date,
    required: true,
    default: Date.now
  },
  status: {
    type: String,
    enum: ['P', 'V', 'C', 'W', 'L'],
    default: 'P'
  },
  resultNumber: {
    type: String,
    trim: true
  },
  resultTime: {
    type: String,
    validate: {
      validator: function(v: string) {
        if (!v) return true; // Optional field
        return /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/.test(v);
      },
      message: 'Result time must be in HH:MM format'
    }
  },
  declaredAt: {
    type: Date
  }
}, {
  timestamps: true
});

// Indexes for better performance
UserGameSchema.index({ customerId: 1, resultDate: 1 });
UserGameSchema.index({ bazarName: 1, resultDate: 1 });
UserGameSchema.index({ gameType: 1, resultDate: 1 });
UserGameSchema.index({ status: 1 });
UserGameSchema.index({ resultDate: 1 });

export const UserGame = mongoose.model<IUserGame>('UserGame', UserGameSchema);

