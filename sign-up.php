import { useState } from 'react';
import { Button } from './components/ui/button';
import { Input } from './components/ui/input';
import { Label } from './components/ui/label';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './components/ui/card';
import { Separator } from './components/ui/separator';
import tecciLogo from 'figma:asset/7e9748de08e2c6d4f1125d27f5f0092f0f9c71e4.png';

export default function App() {
  const [email, setEmail] = useState('');
  const [name, setName] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (password !== confirmPassword) {
      alert('Passwords do not match!');
      return;
    }
    console.log('Sign up attempted with:', { email, name, password });
    // Handle sign up logic here
  };

  const handleGoogleSignUp = () => {
    console.log('Google sign-up clicked');
    // Handle Google OAuth here
  };

  const handleMicrosoftSignUp = () => {
    console.log('Microsoft sign-up clicked');
    // Handle Microsoft OAuth here
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
      {/* Header with Tecci branding */}
      <header className="p-6">
        <div className="flex items-center gap-2">
          <img 
            src={tecciLogo} 
            alt="TECCI Logo" 
            className="h-12"
          />
        </div>
      </header>

      {/* Sign Up Form */}
      <div className="flex items-center justify-center px-4 py-12">
        <Card className="w-full max-w-md">
          <CardHeader className="space-y-1">
            <CardTitle>Create your account</CardTitle>
            <CardDescription>
               Sign up for your Tecci Shop account
               </CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {/* Social Sign-in Buttons */}
              <div className="space-y-3">
                <Button 
                  type="button" 
                  variant="outline" 
                  className="w-full"
                  onClick={handleGoogleSignUp}
                >