import { Request, Response } from 'express';
import { Game } from '../models/Game';
import { getRecordById, deleteRecord, updateRecord, insertRecord, findWithPagination } from '../utils/helpers';

class GameController {
  // Get all games with pagination
  async getAllGames(req: Request, res: Response): Promise<void> {
    try {
      const { page = 1, limit = 10, search, type, status, sortBy = 'createdAt', sortOrder = 'desc' } = req.query;

      // Build filter
      const filter: any = {};
      if (search) {
        filter.name = { $regex: search, $options: 'i' };
      }
      if (type) {
        filter.type = type;
      }
      if (status) {
        filter.status = status;
      }

      // Build sort
      const sort: any = {};
      sort[sortBy as string] = sortOrder === 'desc' ? -1 : 1;

      const result = await findWithPagination(Game, {
        filter,
        page: Number(page),
        limit: Number(limit),
        sort
      });

      res.status(200).json({
        success: true,
        message: 'Games retrieved successfully',
        data: result
      });

    } catch (error) {
      console.error('Get all games error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get game by ID
  async getGameById(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;

      const game = await getRecordById(Game, id);
      
      if (!game) {
        res.status(404).json({
          success: false,
          message: 'Game not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'Game retrieved successfully',
        data: game
      });

    } catch (error) {
      console.error('Get game by ID error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Create new game
  async createGame(req: Request, res: Response): Promise<void> {
    try {
      const gameData = req.body;

      // Check if game with same name already exists
      const existingGame = await Game.findOne({ name: gameData.name });
      if (existingGame) {
        res.status(400).json({
          success: false,
          message: 'Game with this name already exists'
        });
        return;
      }

      const newGame = await insertRecord(Game, gameData);

      res.status(201).json({
        success: true,
        message: 'Game created successfully',
        data: newGame
      });

    } catch (error) {
      console.error('Create game error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Update game
  async updateGame(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;
      const updateData = req.body;

      // Check if name is being updated and if it already exists
      if (updateData.name) {
        const existingGame = await Game.findOne({ 
          name: updateData.name, 
          _id: { $ne: id } 
        });
        if (existingGame) {
          res.status(400).json({
            success: false,
            message: 'Game with this name already exists'
          });
          return;
        }
      }

      const updatedGame = await updateRecord(Game, id, updateData);
      
      if (!updatedGame) {
        res.status(404).json({
          success: false,
          message: 'Game not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'Game updated successfully',
        data: updatedGame
      });

    } catch (error) {
      console.error('Update game error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Delete game
  async deleteGame(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;

      const deletedGame = await deleteRecord(Game, id);
      
      if (!deletedGame) {
        res.status(404).json({
          success: false,
          message: 'Game not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'Game deleted successfully',
        data: { id }
      });

    } catch (error) {
      console.error('Delete game error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Change game status
  async changeGameStatus(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;
      const { status } = req.body;

      if (!['active', 'inactive', 'maintenance'].includes(status)) {
        res.status(400).json({
          success: false,
          message: 'Invalid status value'
        });
        return;
      }

      const updatedGame = await Game.findByIdAndUpdate(
        id,
        { status },
        { new: true }
      );

      if (!updatedGame) {
        res.status(404).json({
          success: false,
          message: 'Game not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'Game status updated successfully',
        data: updatedGame
      });

    } catch (error) {
      console.error('Change game status error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get game statistics
  async getGameStats(req: Request, res: Response): Promise<void> {
    try {
      const stats = await Game.aggregate([
        {
          $group: {
            _id: '$status',
            count: { $sum: 1 }
          }
        }
      ]);

      const typeStats = await Game.aggregate([
        {
          $group: {
            _id: '$type',
            count: { $sum: 1 }
          }
        }
      ]);

      const totalGames = await Game.countDocuments();
      const activeGames = await Game.countDocuments({ status: 'active' });
      const inactiveGames = await Game.countDocuments({ status: 'inactive' });
      const maintenanceGames = await Game.countDocuments({ status: 'maintenance' });

      const result = {
        total: totalGames,
        active: activeGames,
        inactive: inactiveGames,
        maintenance: maintenanceGames,
        statusBreakdown: stats,
        typeBreakdown: typeStats
      };

      res.status(200).json({
        success: true,
        message: 'Game statistics retrieved successfully',
        data: result
      });

    } catch (error) {
      console.error('Get game stats error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Search games
  async searchGames(req: Request, res: Response): Promise<void> {
    try {
      const { q, limit = 10, type } = req.query;

      if (!q) {
        res.status(400).json({
          success: false,
          message: 'Search query is required'
        });
        return;
      }

      const filter: any = {
        name: { $regex: q, $options: 'i' }
      };

      if (type) {
        filter.type = type;
      }

      const games = await Game.find(filter)
        .limit(Number(limit))
        .sort({ createdAt: -1 });

      res.status(200).json({
        success: true,
        message: 'Games search completed',
        data: games
      });

    } catch (error) {
      console.error('Search games error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get games by type
  async getGamesByType(req: Request, res: Response): Promise<void> {
    try {
      const { type } = req.params;
      const { page = 1, limit = 10, status } = req.query;

      const filter: any = { type };
      if (status) {
        filter.status = status;
      }

      const result = await findWithPagination(Game, {
        filter,
        page: Number(page),
        limit: Number(limit),
        sort: { createdAt: -1 }
      });

      res.status(200).json({
        success: true,
        message: `Games of type ${type} retrieved successfully`,
        data: result
      });

    } catch (error) {
      console.error('Get games by type error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }
}

export default new GameController();

