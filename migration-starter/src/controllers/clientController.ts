import { Request, Response } from 'express';
import { User } from '../models/User';
import { UserGame } from '../models/UserGame';
import { GameType } from '../models/GameType';
import { GameResult } from '../models/GameResult';
import { getRecordById, findWithPagination } from '../utils/helpers';

class ClientController {
  // Client Dashboard
  async getClientDashboard(req: Request, res: Response): Promise<void> {
    try {
      const userId = req.user?.id;
      if (!userId) {
        res.status(401).json({
          success: false,
          message: 'Authentication required'
        });
        return;
      }

      const today = new Date();
      today.setHours(0, 0, 0, 0);

      // Get today's statistics for the client
      const todayStats = await UserGame.aggregate([
        {
          $match: {
            customerId: new (require('mongoose').Types.ObjectId)(userId),
            resultDate: { $gte: today }
          }
        },
        {
          $group: {
            _id: null,
            totalBets: { $sum: 1 },
            totalAmount: { $sum: '$pointInRs' },
            totalWinning: { $sum: '$winningInRs' },
            totalCommission: { $sum: '$commissionInRs' }
          }
        },
        {
          $project: {
            _id: 0,
            totalBets: 1,
            totalAmount: 1,
            totalWinning: 1,
            totalCommission: 1
          }
        }
      ]);

      // Get pending bets
      const pendingBets = await UserGame.aggregate([
        {
          $match: {
            customerId: new (require('mongoose').Types.ObjectId)(userId),
            status: 'P'
          }
        },
        {
          $group: {
            _id: null,
            totalBets: { $sum: 1 },
            totalAmount: { $sum: '$pointInRs' }
          }
        },
        {
          $project: {
            _id: 0,
            totalBets: 1,
            totalAmount: 1
          }
        }
      ]);

      // Get recent games
      const recentGames = await UserGame.find({ customerId: userId })
        .sort({ createdAt: -1 })
        .limit(5)
        .populate('bazarName', 'bazarName');

      const dashboardData = {
        today: todayStats[0] || { totalBets: 0, totalAmount: 0, totalWinning: 0, totalCommission: 0 },
        pending: pendingBets[0] || { totalBets: 0, totalAmount: 0 },
        recentGames
      };

      res.status(200).json({
        success: true,
        message: 'Client dashboard data retrieved successfully',
        data: dashboardData
      });

    } catch (error) {
      console.error('Get client dashboard error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get available game types
  async getAvailableGameTypes(req: Request, res: Response): Promise<void> {
    try {
      const { bazarType, status = 'active' } = req.query;

      // Build filter
      const filter: any = { status };
      if (bazarType) {
        filter.bazarType = bazarType;
      }

      const gameTypes = await GameType.find(filter)
        .sort({ priority: 1, bazarName: 1 });

      res.status(200).json({
        success: true,
        message: 'Available game types retrieved successfully',
        data: gameTypes
      });

    } catch (error) {
      console.error('Get available game types error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Place a bet
  async placeBet(req: Request, res: Response): Promise<void> {
    try {
      const userId = req.user?.id;
      if (!userId) {
        res.status(401).json({
          success: false,
          message: 'Authentication required'
        });
        return;
      }

      const { bazarName, gameType, betNumber, betAmount } = req.body;

      // Validate game type exists and is active
      const gameTypeDoc = await GameType.findById(bazarName);
      if (!gameTypeDoc || gameTypeDoc.status !== 'active') {
        res.status(400).json({
          success: false,
          message: 'Invalid or inactive game type'
        });
        return;
      }

      // Calculate commission (example: 5% commission)
      const commissionRate = 0.05;
      const commissionInRs = betAmount * commissionRate;
      const pointInRs = betAmount - commissionInRs;

      const betData = {
        customerId: userId,
        bazarName,
        gameType,
        betNumber,
        betAmount,
        pointInRs,
        winningInRs: 0,
        commissionInRs,
        resultDate: new Date(),
        status: 'P'
      };

      const newBet = await UserGame.create(betData);

      res.status(201).json({
        success: true,
        message: 'Bet placed successfully',
        data: newBet
      });

    } catch (error) {
      console.error('Place bet error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get user's betting history
  async getBettingHistory(req: Request, res: Response): Promise<void> {
    try {
      const userId = req.user?.id;
      if (!userId) {
        res.status(401).json({
          success: false,
          message: 'Authentication required'
        });
        return;
      }

      const { page = 1, limit = 10, gameType, status, resultDate, sortBy = 'createdAt', sortOrder = 'desc' } = req.query;

      // Build filter
      const filter: any = { customerId: userId };
      if (gameType) {
        filter.gameType = gameType;
      }
      if (status) {
        filter.status = status;
      }
      if (resultDate) {
        const date = new Date(resultDate as string);
        date.setHours(0, 0, 0, 0);
        const nextDate = new Date(date);
        nextDate.setDate(date.getDate() + 1);
        filter.resultDate = { $gte: date, $lt: nextDate };
      }

      // Build sort
      const sort: any = {};
      sort[sortBy as string] = sortOrder === 'desc' ? -1 : 1;

      const result = await findWithPagination(UserGame, {
        filter,
        page: Number(page),
        limit: Number(limit),
        sort,
        populate: 'bazarName'
      });

      res.status(200).json({
        success: true,
        message: 'Betting history retrieved successfully',
        data: result
      });

    } catch (error) {
      console.error('Get betting history error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get game results
  async getGameResults(req: Request, res: Response): Promise<void> {
    try {
      const { page = 1, limit = 10, gameType, resultDate, sortBy = 'createdAt', sortOrder = 'desc' } = req.query;

      // Build filter
      const filter: any = { status: { $in: ['V', 'D'] } }; // Verified or Declared results only
      if (gameType) {
        filter.resultType = gameType;
      }
      if (resultDate) {
        const date = new Date(resultDate as string);
        date.setHours(0, 0, 0, 0);
        const nextDate = new Date(date);
        nextDate.setDate(date.getDate() + 1);
        filter.resultDate = { $gte: date, $lt: nextDate };
      }

      // Build sort
      const sort: any = {};
      sort[sortBy as string] = sortOrder === 'desc' ? -1 : 1;

      const result = await findWithPagination(GameResult, {
        filter,
        page: Number(page),
        limit: Number(limit),
        sort,
        populate: 'bazarName'
      });

      res.status(200).json({
        success: true,
        message: 'Game results retrieved successfully',
        data: result
      });

    } catch (error) {
      console.error('Get game results error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get user profile
  async getUserProfile(req: Request, res: Response): Promise<void> {
    try {
      const userId = req.user?.id;
      if (!userId) {
        res.status(401).json({
          success: false,
          message: 'Authentication required'
        });
        return;
      }

      const user = await User.findById(userId).select('-password -refreshToken');
      if (!user) {
        res.status(404).json({
          success: false,
          message: 'User not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'User profile retrieved successfully',
        data: user
      });

    } catch (error) {
      console.error('Get user profile error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Update user profile
  async updateUserProfile(req: Request, res: Response): Promise<void> {
    try {
      const userId = req.user?.id;
      if (!userId) {
        res.status(401).json({
          success: false,
          message: 'Authentication required'
        });
        return;
      }

      const updateData = req.body;
      
      // Remove sensitive fields from update data
      delete updateData.password;
      delete updateData.refreshToken;
      delete updateData.email; // Prevent email change through this endpoint
      delete updateData.role;
      delete updateData.status;

      const updatedUser = await User.findByIdAndUpdate(
        userId,
        updateData,
        { new: true, select: '-password -refreshToken' }
      );

      if (!updatedUser) {
        res.status(404).json({
          success: false,
          message: 'User not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'User profile updated successfully',
        data: updatedUser
      });

    } catch (error) {
      console.error('Update user profile error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get user statistics
  async getUserStats(req: Request, res: Response): Promise<void> {
    try {
      const userId = req.user?.id;
      if (!userId) {
        res.status(401).json({
          success: false,
          message: 'Authentication required'
        });
        return;
      }

      const { startDate, endDate } = req.query;

      // Build date filter
      const dateFilter: any = {};
      if (startDate && endDate) {
        const start = new Date(startDate as string);
        const end = new Date(endDate as string);
        end.setHours(23, 59, 59, 999);
        dateFilter.resultDate = { $gte: start, $lte: end };
      }

      // Get overall statistics
      const overallStats = await UserGame.aggregate([
        {
          $match: {
            customerId: new (require('mongoose').Types.ObjectId)(userId),
            ...dateFilter
          }
        },
        {
          $group: {
            _id: null,
            totalBets: { $sum: 1 },
            totalAmount: { $sum: '$pointInRs' },
            totalWinning: { $sum: '$winningInRs' },
            totalCommission: { $sum: '$commissionInRs' }
          }
        },
        {
          $project: {
            _id: 0,
            totalBets: 1,
            totalAmount: 1,
            totalWinning: 1,
            totalCommission: 1
          }
        }
      ]);

      // Get statistics by game type
      const gameTypeStats = await UserGame.aggregate([
        {
          $match: {
            customerId: new (require('mongoose').Types.ObjectId)(userId),
            ...dateFilter
          }
        },
        {
          $group: {
            _id: '$gameType',
            totalBets: { $sum: 1 },
            totalAmount: { $sum: '$pointInRs' },
            totalWinning: { $sum: '$winningInRs' },
            totalCommission: { $sum: '$commissionInRs' }
          }
        }
      ]);

      // Get statistics by status
      const statusStats = await UserGame.aggregate([
        {
          $match: {
            customerId: new (require('mongoose').Types.ObjectId)(userId),
            ...dateFilter
          }
        },
        {
          $group: {
            _id: '$status',
            totalBets: { $sum: 1 },
            totalAmount: { $sum: '$pointInRs' }
          }
        }
      ]);

      const statsData = {
        overall: overallStats[0] || { totalBets: 0, totalAmount: 0, totalWinning: 0, totalCommission: 0 },
        byGameType: gameTypeStats,
        byStatus: statusStats
      };

      res.status(200).json({
        success: true,
        message: 'User statistics retrieved successfully',
        data: statsData
      });

    } catch (error) {
      console.error('Get user stats error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }
}

export default new ClientController();

