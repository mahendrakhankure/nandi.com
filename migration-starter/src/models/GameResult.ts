import mongoose, { Schema, Document } from 'mongoose';

export interface IGameResult extends Document {
  bazarName: mongoose.Types.ObjectId;
  resultDate: Date;
  resultTime: string;
  resultNumber: string;
  resultType: 'regular' | 'starline' | 'kingbazar' | 'worli' | 'instantworli';
  status: 'P' | 'V' | 'C' | 'D'; // Pending, Verified, Cancelled, Declared
  declaredBy?: mongoose.Types.ObjectId;
  declaredAt?: Date;
  totalBets: number;
  totalAmount: number;
  totalWinning: number;
  totalCommission: number;
  createdAt: Date;
  updatedAt: Date;
}

const GameResultSchema: Schema = new Schema({
  bazarName: {
    type: Schema.Types.ObjectId,
    ref: 'GameType',
    required: true
  },
  resultDate: {
    type: Date,
    required: true,
    default: Date.now
  },
  resultTime: {
    type: String,
    required: true,
    validate: {
      validator: function(v: string) {
        return /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/.test(v);
      },
      message: 'Result time must be in HH:MM format'
    }
  },
  resultNumber: {
    type: String,
    required: true,
    trim: true
  },
  resultType: {
    type: String,
    enum: ['regular', 'starline', 'kingbazar', 'worli', 'instantworli'],
    required: true
  },
  status: {
    type: String,
    enum: ['P', 'V', 'C', 'D'],
    default: 'P'
  },
  declaredBy: {
    type: Schema.Types.ObjectId,
    ref: 'Admin'
  },
  declaredAt: {
    type: Date
  },
  totalBets: {
    type: Number,
    default: 0
  },
  totalAmount: {
    type: Number,
    default: 0
  },
  totalWinning: {
    type: Number,
    default: 0
  },
  totalCommission: {
    type: Number,
    default: 0
  }
}, {
  timestamps: true
});

// Indexes for better performance
GameResultSchema.index({ bazarName: 1, resultDate: 1 });
GameResultSchema.index({ resultType: 1, resultDate: 1 });
GameResultSchema.index({ status: 1 });
GameResultSchema.index({ resultDate: 1 });

export const GameResult = mongoose.model<IGameResult>('GameResult', GameResultSchema);

