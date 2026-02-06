import mongoose, { Schema, Document } from 'mongoose';

export interface IGameType extends Document {
  bazarName: string;
  bazarType: 'Out' | 'InHome' | 'Home';
  startTime: string;
  endTime: string;
  priority: number;
  daysInWeek: string[];
  resultMode: string;
  status: 'active' | 'inactive';
  createdAt: Date;
  updatedAt: Date;
}

const GameTypeSchema: Schema = new Schema({
  bazarName: {
    type: String,
    required: true,
    unique: true,
    trim: true
  },
  bazarType: {
    type: String,
    enum: ['Out', 'InHome', 'Home'],
    required: true
  },
  startTime: {
    type: String,
    required: true,
    validate: {
      validator: function(v: string) {
        return /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/.test(v);
      },
      message: 'Start time must be in HH:MM format'
    }
  },
  endTime: {
    type: String,
    required: true,
    validate: {
      validator: function(v: string) {
        return /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/.test(v);
      },
      message: 'End time must be in HH:MM format'
    }
  },
  priority: {
    type: Number,
    default: 1,
    min: 1,
    max: 100
  },
  daysInWeek: [{
    type: String,
    enum: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
  }],
  resultMode: {
    type: String,
    required: true,
    enum: ['manual', 'auto', 'api']
  },
  status: {
    type: String,
    enum: ['active', 'inactive'],
    default: 'active'
  }
}, {
  timestamps: true
});

// Indexes for better performance
GameTypeSchema.index({ bazarName: 1 });
GameTypeSchema.index({ bazarType: 1 });
GameTypeSchema.index({ status: 1 });
GameTypeSchema.index({ startTime: 1, endTime: 1 });

export const GameType = mongoose.model<IGameType>('GameType', GameTypeSchema);

