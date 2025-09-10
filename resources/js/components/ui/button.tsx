import * as React from "react";
import { cn } from "@/lib/utils";

const buttonVariants = {
  base: "inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-blue-500 disabled:pointer-events-none disabled:opacity-50",
  variants: {
    default: "bg-blue-600 text-white shadow hover:bg-blue-700",
    destructive: "bg-red-600 text-white shadow-sm hover:bg-red-700",
    outline: "border border-gray-300 bg-white shadow-sm hover:bg-gray-50 hover:text-gray-900",
    secondary: "bg-gray-100 text-gray-900 shadow-sm hover:bg-gray-200",
    ghost: "hover:bg-gray-100 hover:text-gray-900",
    link: "text-blue-600 underline-offset-4 hover:underline",
  },
  sizes: {
    default: "h-9 px-4 py-2",
    sm: "h-8 rounded-md px-3 text-xs",
    lg: "h-10 rounded-md px-8",
    icon: "h-9 w-9",
  },
};

export interface ButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
  variant?: 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link';
  size?: 'default' | 'sm' | 'lg' | 'icon';
  asChild?: boolean;
}

const Button = React.forwardRef<HTMLButtonElement, ButtonProps>(
  ({ className, variant = 'default', size = 'default', asChild = false, children, ...props }, ref) => {
    const baseClasses = buttonVariants.base;
    const variantClasses = buttonVariants.variants[variant];
    const sizeClasses = buttonVariants.sizes[size];
    const classes = cn(baseClasses, variantClasses, sizeClasses, className);
    
    // Simple asChild implementation - just pass className to child
    if (asChild) {
      return <div className={classes}>{children}</div>;
    }
    
    return (
      <button
        className={classes}
        ref={ref}
        {...props}
      >
        {children}
      </button>
    );
  }
);
Button.displayName = "Button";

export { Button, buttonVariants };