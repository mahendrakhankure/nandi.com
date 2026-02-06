import mongoose, { Document, Schema } from 'mongoose';

export interface IGame extends Document {
  name: string;
  type: string;
  status: string;
  description?: string;
  rules?: string;
  createdAt: Date;
  updatedAt: Date;
}

const GameSchema = new Schema<IGame>({
  name: {
    type: String,
    required: [true, 'Game name is required'],
    unique: true,
    trim: true,
    minlength: [2, 'Game name must be at least 2 characters'],
    maxlength: [100, 'Game name cannot exceed 100 characters']
  },
  type: {
    type: String,
    required: [true, 'Game type is required'],
    enum: ['card', 'board', 'digital', 'puzzle', 'action', 'strategy', 'other'],
    default: 'other'
  },
  status: {
    type: String,
    enum: ['active', 'inactive', 'maintenance'],
    default: 'active'
  },
  description: {
    type: String,
    maxlength: [500, 'Description cannot exceed 500 characters']
  },
  rules: {
    type: String,
    maxlength: [2000, 'Rules cannot exceed 2000 characters']
  }
}, {
  timestamps: true,
  toJSON: { virtuals: true },
  toObject: { virtuals: true }
});

// Indexes for better performance
GameSchema.index({ name: 1 });
GameSchema.index({ type: 1 });
GameSchema.index({ status: 1 });
GameSchema.index({ createdAt: -1 });

export const Game = mongoose.model<IGame>('Game', GameSchema);

