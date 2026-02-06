import { Request, Response } from 'express';
import { Admin } from '../models/Admin';
import { User } from '../models/User';
import { GameType } from '../models/GameType';
import { GameResult } from '../models/GameResult';
import { UserGame } from '../models/UserGame';
import { CurrencyRate } from '../models/CurrencyRate';
import { getRecordById, deleteRecord, updateRecord, insertRecord, findWithPagination } from '../utils/helpers';

class AdminController {
  // Admin Dashboard
  async getDashboard(req: Request, res: Response): Promise<void> {
    try {
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      // Get today's statistics
      const regularStats = await UserGame.aggregate([
        {
          $match: {
            resultDate: { $gte: today },
            status: { $nin: ['V', 'P'] },
            gameType: 'regular'
          }
        },
        {
          $group: {
            _id: null,
            totalBets: { $sum: 1 },
            totalAmount: { $sum: '$pointInRs' },
            totalWinning: { $sum: '$winningInRs' },
            totalCommission: { $sum: '$commissionInRs' },
            uniquePlayers: { $addToSet: '$customerId' }
          }
        },
        {
          $project: {
            _id: 0,
            totalBets: 1,
            totalAmount: 1,
            totalWinning: 1,
            totalCommission: 1,
            uniquePlayers: { $size: '$uniquePlayers' }
          }
        }
      ]);

      const starlineStats = await UserGame.aggregate([
        {
          $match: {
            resultDate: { $gte: today },
            status: { $nin: ['V', 'P'] },
            gameType: 'starline'
          }
        },
        {
          $group: {
            _id: null,
            totalBets: { $sum: 1 },
            totalAmount: { $sum: '$pointInRs' },
            totalWinning: { $sum: '$winningInRs' },
            totalCommission: { $sum: '$commissionInRs' },
            uniquePlayers: { $addToSet: '$customerId' }
          }
        },
        {
          $project: {
            _id: 0,
            totalBets: 1,
            totalAmount: 1,
            totalWinning: 1,
            totalCommission: 1,
            uniquePlayers: { $size: '$uniquePlayers' }
          }
        }
      ]);

      const kingbazarStats = await UserGame.aggregate([
        {
          $match: {
            resultDate: { $gte: today },
            status: { $nin: ['V', 'P'] },
            gameType: 'kingbazar'
          }
        },
        {
          $group: {
            _id: null,
            totalBets: { $sum: 1 },
            totalAmount: { $sum: '$pointInRs' },
            totalWinning: { $sum: '$winningInRs' },
            totalCommission: { $sum: '$commissionInRs' },
            uniquePlayers: { $addToSet: '$customerId' }
          }
        },
        {
          $project: {
            _id: 0,
            totalBets: 1,
            totalAmount: 1,
            totalWinning: 1,
            totalCommission: 1,
            uniquePlayers: { $size: '$uniquePlayers' }
          }
        }
      ]);

      const worliStats = await UserGame.aggregate([
        {
          $match: {
            resultDate: { $gte: today },
            status: { $nin: ['V', 'P'] },
            gameType: 'worli'
          }
        },
        {
          $group: {
            _id: null,
            totalBets: { $sum: 1 },
            totalAmount: { $sum: '$pointInRs' },
            totalWinning: { $sum: '$winningInRs' },
            totalCommission: { $sum: '$commissionInRs' },
            uniquePlayers: { $addToSet: '$customerId' }
          }
        },
        {
          $project: {
            _id: 0,
            totalBets: 1,
            totalAmount: 1,
            totalWinning: 1,
            totalCommission: 1,
            uniquePlayers: { $size: '$uniquePlayers' }
          }
        }
      ]);

      // Get pending statistics
      const pendingStats = await UserGame.aggregate([
        {
          $match: {
            resultDate: { $gte: today },
            status: 'P'
          }
        },
        {
          $group: {
            _id: null,
            totalBets: { $sum: 1 },
            totalAmount: { $sum: '$pointInRs' },
            totalCommission: { $sum: '$commissionInRs' },
            uniquePlayers: { $addToSet: '$customerId' }
          }
        },
        {
          $project: {
            _id: 0,
            totalBets: 1,
            totalAmount: 1,
            totalCommission: 1,
            uniquePlayers: { $size: '$uniquePlayers' }
          }
        }
      ]);

      const dashboardData = {
        regular: regularStats[0] || { totalBets: 0, totalAmount: 0, totalWinning: 0, totalCommission: 0, uniquePlayers: 0 },
        starline: starlineStats[0] || { totalBets: 0, totalAmount: 0, totalWinning: 0, totalCommission: 0, uniquePlayers: 0 },
        kingbazar: kingbazarStats[0] || { totalBets: 0, totalAmount: 0, totalWinning: 0, totalCommission: 0, uniquePlayers: 0 },
        worli: worliStats[0] || { totalBets: 0, totalAmount: 0, totalWinning: 0, totalCommission: 0, uniquePlayers: 0 },
        pending: pendingStats[0] || { totalBets: 0, totalAmount: 0, totalCommission: 0, uniquePlayers: 0 }
      };

      res.status(200).json({
        success: true,
        message: 'Dashboard data retrieved successfully',
        data: dashboardData
      });

    } catch (error) {
      console.error('Get dashboard error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Manage Game Types
  async getAllGameTypes(req: Request, res: Response): Promise<void> {
    try {
      const { page = 1, limit = 10, search, bazarType, status, sortBy = 'createdAt', sortOrder = 'desc' } = req.query;

      // Build filter
      const filter: any = {};
      if (search) {
        filter.bazarName = { $regex: search, $options: 'i' };
      }
      if (bazarType) {
        filter.bazarType = bazarType;
      }
      if (status) {
        filter.status = status;
      }

      // Build sort
      const sort: any = {};
      sort[sortBy as string] = sortOrder === 'desc' ? -1 : 1;

      const result = await findWithPagination(GameType, {
        filter,
        page: Number(page),
        limit: Number(limit),
        sort,
        populate: 'bazarName'
      });

      res.status(200).json({
        success: true,
        message: 'Game types retrieved successfully',
        data: result
      });

    } catch (error) {
      console.error('Get all game types error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  async createGameType(req: Request, res: Response): Promise<void> {
    try {
      const gameTypeData = req.body;

      // Check if game type with same name already exists
      const existingGameType = await GameType.findOne({ bazarName: gameTypeData.bazarName });
      if (existingGameType) {
        res.status(400).json({
          success: false,
          message: 'Game type with this name already exists'
        });
        return;
      }

      const newGameType = await insertRecord(GameType, gameTypeData);

      res.status(201).json({
        success: true,
        message: 'Game type created successfully',
        data: newGameType
      });

    } catch (error) {
      console.error('Create game type error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  async updateGameType(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;
      const updateData = req.body;

      // Check if name is being updated and if it already exists
      if (updateData.bazarName) {
        const existingGameType = await GameType.findOne({ 
          bazarName: updateData.bazarName, 
          _id: { $ne: id } 
        });
        if (existingGameType) {
          res.status(400).json({
            success: false,
            message: 'Game type with this name already exists'
          });
          return;
        }
      }

      const updatedGameType = await updateRecord(GameType, id, updateData);
      
      if (!updatedGameType) {
        res.status(404).json({
          success: false,
          message: 'Game type not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'Game type updated successfully',
        data: updatedGameType
      });

    } catch (error) {
      console.error('Update game type error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  async deleteGameType(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;

      // Check if there are any active games using this game type
      const activeGames = await UserGame.findOne({ bazarName: id });
      if (activeGames) {
        res.status(400).json({
          success: false,
          message: 'Cannot delete game type with active games'
        });
        return;
      }

      const deletedGameType = await deleteRecord(GameType, id);
      
      if (!deletedGameType) {
        res.status(404).json({
          success: false,
          message: 'Game type not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'Game type deleted successfully',
        data: { id }
      });

    } catch (error) {
      console.error('Delete game type error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Manage Game Results
  async getAllGameResults(req: Request, res: Response): Promise<void> {
    try {
      const { page = 1, limit = 10, search, gameType, status, resultDate, sortBy = 'createdAt', sortOrder = 'desc' } = req.query;

      // Build filter
      const filter: any = {};
      if (search) {
        filter.resultNumber = { $regex: search, $options: 'i' };
      }
      if (gameType) {
        filter.resultType = gameType;
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

      const result = await findWithPagination(GameResult, {
        filter,
        page: Number(page),
        limit: Number(limit),
        sort,
        populate: 'bazarName declaredBy'
      });

      res.status(200).json({
        success: true,
        message: 'Game results retrieved successfully',
        data: result
      });

    } catch (error) {
      console.error('Get all game results error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  async createGameResult(req: Request, res: Response): Promise<void> {
    try {
      const resultData = req.body;
      resultData.declaredBy = req.user?.id;

      const newGameResult = await insertRecord(GameResult, resultData);

      res.status(201).json({
        success: true,
        message: 'Game result created successfully',
        data: newGameResult
      });

    } catch (error) {
      console.error('Create game result error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  async updateGameResult(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;
      const updateData = req.body;

      const updatedGameResult = await updateRecord(GameResult, id, updateData);
      
      if (!updatedGameResult) {
        res.status(404).json({
          success: false,
          message: 'Game result not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'Game result updated successfully',
        data: updatedGameResult
      });

    } catch (error) {
      console.error('Update game result error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  async deleteGameResult(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;

      const deletedGameResult = await deleteRecord(GameResult, id);
      
      if (!deletedGameResult) {
        res.status(404).json({
          success: false,
          message: 'Game result not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'Game result deleted successfully',
        data: { id }
      });

    } catch (error) {
      console.error('Delete game result error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Manage Currency Rates
  async getAllCurrencyRates(req: Request, res: Response): Promise<void> {
    try {
      const { page = 1, limit = 10, search, status, sortBy = 'createdAt', sortOrder = 'desc' } = req.query;

      // Build filter
      const filter: any = {};
      if (search) {
        filter.$or = [
          { currencyCode: { $regex: search, $options: 'i' } },
          { currencyName: { $regex: search, $options: 'i' } }
        ];
      }
      if (status) {
        filter.status = status;
      }

      // Build sort
      const sort: any = {};
      sort[sortBy as string] = sortOrder === 'desc' ? -1 : 1;

      const result = await findWithPagination(CurrencyRate, {
        filter,
        page: Number(page),
        limit: Number(limit),
        sort,
        populate: 'updatedBy'
      });

      res.status(200).json({
        success: true,
        message: 'Currency rates retrieved successfully',
        data: result
      });

    } catch (error) {
      console.error('Get all currency rates error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  async createCurrencyRate(req: Request, res: Response): Promise<void> {
    try {
      const currencyData = req.body;
      currencyData.updatedBy = req.user?.id;

      // Check if currency rate with same code already exists
      const existingCurrency = await CurrencyRate.findOne({ currencyCode: currencyData.currencyCode });
      if (existingCurrency) {
        res.status(400).json({
          success: false,
          message: 'Currency rate with this code already exists'
        });
        return;
      }

      const newCurrencyRate = await insertRecord(CurrencyRate, currencyData);

      res.status(201).json({
        success: true,
        message: 'Currency rate created successfully',
        data: newCurrencyRate
      });

    } catch (error) {
      console.error('Create currency rate error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  async updateCurrencyRate(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;
      const updateData = req.body;
      updateData.updatedBy = req.user?.id;

      const updatedCurrencyRate = await updateRecord(CurrencyRate, id, updateData);
      
      if (!updatedCurrencyRate) {
        res.status(404).json({
          success: false,
          message: 'Currency rate not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'Currency rate updated successfully',
        data: updatedCurrencyRate
      });

    } catch (error) {
      console.error('Update currency rate error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  async deleteCurrencyRate(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;

      const deletedCurrencyRate = await deleteRecord(CurrencyRate, id);
      
      if (!deletedCurrencyRate) {
        res.status(404).json({
          success: false,
          message: 'Currency rate not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'Currency rate deleted successfully',
        data: { id }
      });

    } catch (error) {
      console.error('Delete currency rate error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }
}

export default new AdminController();

