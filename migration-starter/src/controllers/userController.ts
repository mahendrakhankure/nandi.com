import { Request, Response } from 'express';
import { User } from '../models/User';
import { getRecordById, deleteRecord, updateRecord, insertRecord, findWithPagination } from '../utils/helpers';

class UserController {
  // Get all users with pagination
  async getAllUsers(req: Request, res: Response): Promise<void> {
    try {
      const { page = 1, limit = 10, search, status, sortBy = 'createdAt', sortOrder = 'desc' } = req.query;

      // Build filter
      const filter: any = {};
      if (search) {
        filter.$or = [
          { username: { $regex: search, $options: 'i' } },
          { email: { $regex: search, $options: 'i' } }
        ];
      }
      if (status) {
        filter.status = status;
      }

      // Build sort
      const sort: any = {};
      sort[sortBy as string] = sortOrder === 'desc' ? -1 : 1;

      const result = await findWithPagination(User, {
        filter,
        page: Number(page),
        limit: Number(limit),
        sort,
        select: '-password -refreshToken'
      });

      res.status(200).json({
        success: true,
        message: 'Users retrieved successfully',
        data: result
      });

    } catch (error) {
      console.error('Get all users error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get user by ID
  async getUserById(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;

      const user = await getRecordById(User, id, '-password -refreshToken');
      
      if (!user) {
        res.status(404).json({
          success: false,
          message: 'User not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'User retrieved successfully',
        data: user
      });

    } catch (error) {
      console.error('Get user by ID error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Update user
  async updateUser(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;
      const updateData = req.body;

      // Remove sensitive fields from update data
      delete updateData.password;
      delete updateData.refreshToken;
      delete updateData.email; // Prevent email change through this endpoint

      const updatedUser = await updateRecord(User, id, updateData, '-password -refreshToken');
      
      if (!updatedUser) {
        res.status(404).json({
          success: false,
          message: 'User not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'User updated successfully',
        data: updatedUser
      });

    } catch (error) {
      console.error('Update user error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Delete user
  async deleteUser(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;

      const deletedUser = await deleteRecord(User, id);
      
      if (!deletedUser) {
        res.status(404).json({
          success: false,
          message: 'User not found'
        });
        return;
      }

      res.status(200).json({
        success: true,
        message: 'User deleted successfully',
        data: { id }
      });

    } catch (error) {
      console.error('Delete user error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Change user status
  async changeUserStatus(req: Request, res: Response): Promise<void> {
    try {
      const { id } = req.params;
      const { status } = req.body;

      if (!['active', 'inactive', 'suspended'].includes(status)) {
        res.status(400).json({
          success: false,
          message: 'Invalid status value'
        });
        return;
      }

      const updatedUser = await User.findByIdAndUpdate(
        id,
        { status },
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
        message: 'User status updated successfully',
        data: updatedUser
      });

    } catch (error) {
      console.error('Change user status error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Get user statistics
  async getUserStats(req: Request, res: Response): Promise<void> {
    try {
      const stats = await User.aggregate([
        {
          $group: {
            _id: '$status',
            count: { $sum: 1 }
          }
        }
      ]);

      const totalUsers = await User.countDocuments();
      const activeUsers = await User.countDocuments({ status: 'active' });
      const inactiveUsers = await User.countDocuments({ status: 'inactive' });
      const suspendedUsers = await User.countDocuments({ status: 'suspended' });

      const result = {
        total: totalUsers,
        active: activeUsers,
        inactive: inactiveUsers,
        suspended: suspendedUsers,
        breakdown: stats
      };

      res.status(200).json({
        success: true,
        message: 'User statistics retrieved successfully',
        data: result
      });

    } catch (error) {
      console.error('Get user stats error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }

  // Search users
  async searchUsers(req: Request, res: Response): Promise<void> {
    try {
      const { q, limit = 10 } = req.query;

      if (!q) {
        res.status(400).json({
          success: false,
          message: 'Search query is required'
        });
        return;
      }

      const users = await User.find({
        $or: [
          { username: { $regex: q, $options: 'i' } },
          { email: { $regex: q, $options: 'i' } }
        ]
      })
      .select('-password -refreshToken')
      .limit(Number(limit))
      .sort({ createdAt: -1 });

      res.status(200).json({
        success: true,
        message: 'Users search completed',
        data: users
      });

    } catch (error) {
      console.error('Search users error:', error);
      res.status(500).json({
        success: false,
        message: 'Internal server error'
      });
    }
  }
}

export default new UserController();

